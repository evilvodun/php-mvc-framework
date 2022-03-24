<?php

namespace App\Auth;

use Exception;
use App\Models\User;
use App\Auth\Recaller;
use App\Cookie\CookieJar;
use Doctrine\ORM\EntityManager;
use App\Auth\Hashing\HasherInterface;
use App\Session\SessionStoreInterface;

class Auth
{
    protected $db;

    protected $hash;

    protected $session;

    protected $user;

    protected $recaller;

    protected $cookie;

    public function __construct(
        EntityManager $db,
        HasherInterface $hash,
        SessionStoreInterface $session,
        Recaller $recaller,
        CookieJar $cookie
    ) {
        $this->db = $db;
        $this->hash = $hash;
        $this->session = $session;
        $this->recaller = $recaller;
        $this->cookie = $cookie;
    }

    public function logout()
    {
        $this->session->clear($this->key());
    }

    public function attempt($email, $password, $remember = false)
    {
        $user = $this->getByUsername($email);

        if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        if ($this->needsRehash($user)) {
            $this->rehashPassword($user, $password);
        }

        if ($remember) {
            $this->setRememberToken($user);
        }

        $this->setUserSession($user);

        return true;
    }

    protected function setRememberToken($user)
    {
        list($identifier, $token) = $this->recaller->generate();
        $this->cookie->set('remember', $this->recaller->generateValueForCookie($identifier, $token));

        $this->db->getRepository(User::class)->find($user->id)->update([
            'remember_identifier' => $identifier,
            'remember_token' => $this->recaller->getTokenHashForDatabase($token)
        ]);

        $this->db->flush();
    }

    protected function needsRehash($user)
    {
        return $this->hash->needsRehash($user->password);
    }

    protected function rehashPassword($user, $password)
    {
        $this->db->getRepository(User::class)->find($user->id)->update([
            'password' => $this->hash->create($password)
        ]);

        $this->db->flush();
    }

    public function user()
    {
        return $this->user;
    }

    public function check()
    {
        return $this->hasUserInSession();
    }

    public function hasUserInSession()
    {
        return $this->session->exists($this->key());
    }

    public function setUserFromSession()
    {
        $user = $this->getById($this->session->get($this->key()));

        if (!$user) {
            throw new Exception();
        }

        $this->user = $user;
    }

    protected function getById($id)
    {
        return $this->db->getRepository(User::class)->find($id);
    }

    protected function setUserSession($user)
    {
        $this->session->set($this->key(), $user->id);
    }

    protected function key()
    {
        return 'id';
    }

    protected function hasValidCredentials($user, $password)
    {
        return $this->hash->check($password, $user->password);
    }

    protected function getByUsername($email)
    {
        return $this->db->getRepository(User::class)->findOneBy([
            'email' => $email
        ]);
    }
}
