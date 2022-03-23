<?php
namespace App\Security;

use App\Session\SessionStoreInterface;

class Csrf
{
    protected $persistToken = false;
    protected $session;

    public function __construct(SessionStoreInterface $session)
    {
        $this->session = $session;
    }

    public function token()
    {
        if(!$this->tokenNeedsToBeGenerated()) {
            return $this->getTokenFromSession();
        }

        $this->session->set(
            $this->key(), 
            $token = bin2hex(random_bytes(32))
        );

        return $token;
    }

    public function key()
    {
        return '_token';
    }

    public function tokenIsValid($token)
    {
        return $token === $this->session->get($this->key());
    }

    protected function getTokenFromSession()
    {
        return $this->session->get($this->key());
    }

    protected function tokenNeedsToBeGenerated()
    {
        if(!$this->session->exists($this->key())) {
            return true;
        }

        if($this->shouldPersistToken()) {
            return false;
        }
        
        return $this->session->exists($this->key());
    }

    protected function shouldPersistToken()
    {
        return $this->persistToken;
    }
}