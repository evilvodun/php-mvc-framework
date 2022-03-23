<?php

namespace App\Auth;

use App\Models\User;
use Doctrine\ORM\EntityManager;
use App\Auth\Hashing\HasherInterface;
use App\Session\SessionStoreInterface;
use Exception;

class Auth
{
    protected $db;

    protected $hash;

    protected $session;

    protected $user;

    public function __construct(EntityManager $db, HasherInterface $hash, SessionStoreInterface $session)
    {
        $this->db = $db;
        $this->hash = $hash;
        $this->session = $session;
    }

    public function attempt($email, $password)
    {
        $user = $this->getByUsername($email);

         if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        $this->setUserSession($user);

        return true;
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

        if(!$user) {
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
