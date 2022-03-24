<?php

namespace App\Controllers;

use App\Views\View;
use App\Cookie\CookieJar;
use Laminas\Diactoros\Response;

class HomeController 
{
    protected $view;

    protected $response;

    protected $cookie;
    
    public function __construct(View $view, Response $response, CookieJar $cookie)
    {
        $this->view = $view;
        $this->response = $response;
        $this->cookie = $cookie;
    }

    public function index($request)
    {
        $this->cookie->clear('abc');

        return $this->view->render($this->response, 'home.twig');
    }
}