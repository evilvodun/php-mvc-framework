<?php

namespace App\Auth;

use Exception;
use App\Auth\Recaller;
use App\Cookie\CookieJar;
use App\Auth\Hashing\HasherInterface;
use App\Session\SessionStoreInterface;
use App\Auth\Providers\UserProviderInterface;

class Auth
{
    protected $hash;

    protected $session;

    protected $user;

    protected $recaller;

    protected $cookie;

    protected $provider;

    public function __construct(
        HasherInterface $hash,
        SessionStoreInterface $session,
        Recaller $recaller,
        CookieJar $cookie,
        UserProviderInterface $provider
    ) {
        $this->hash = $hash;
        $this->session = $session;
        $this->recaller = $recaller;
        $this->cookie = $cookie;
        $this->provider = $provider;
    }

    public function logout()
    {
        $this->provider->clearUserRememberToken($this->user->id);
        $this->cookie->clear('remember');
        $this->session->clear($this->key());
    }

    public function attempt($email, $password, $remember = false)
    {
        $user = $this->provider->getByUsername($email);

        if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        if ($this->needsRehash($user)) {
            $this->provider->updateUserPasswordHash($user->id, $this->hash->create($password));
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

        $this->provider->setUserRememberToken(
            $user->id,
            $identifier,
            $this->recaller->getTokenHashForDatabase($token)
        );
    }

    protected function needsRehash($user)
    {
        return $this->hash->needsRehash($user->password);
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
        $user = $this->provider->getById($this->session->get($this->key()));

        if (!$user) {
            throw new Exception();
        }

        $this->user = $user;
    }
    public function setUserFromCookie()
    {
        list($identifier, $token) = $this->recaller->splitCookieValue(
            $this->cookie->get('remember')
        );

        if (!$user = $this->provider->getUserByRememberIdentifier($identifier)) {
            $this->cookie->clear('remember');
            return;
        }

        if (!$this->recaller->validateToken($token, $user->remember_token)) {
            $this->provider->clearUserRememberToken($user->id);
            $this->cookie->clear('remember');

            throw new Exception();
        }

        $this->setUserSession($user);
    }

    public function hasRecaller()
    {
        return $this->cookie->exists('remember');
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
}
