<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Views\View;
use Laminas\Diactoros\Response;
use App\Auth\Hashing\HasherInterface;
use App\Session\SessionStoreInterface;

class HomeController 
{
    protected $view;

    protected $response;

    protected $hasher;

    protected $auth;
    protected $session;
    
    public function __construct(View $view, Response $response, HasherInterface $hasher, Auth $auth, SessionStoreInterface $session)
    {
        $this->view = $view;
        $this->response = $response;
        $this->hasher = $hasher;
        $this->auth = $auth;
        $this->session = $session;
    }

    public function index($request)
    {
        // dump($this->auth->user());
        return $this->view->render($this->response, 'home.twig', [
            'user' => $this->auth->user()
        ]);
    }
}