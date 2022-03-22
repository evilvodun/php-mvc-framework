<?php

namespace App\Controllers;

use App\Views\View;
use League\Route\Router;
use Laminas\Diactoros\Response;

class HomeController 
{
    protected $view;
    protected $response;
    
    public function __construct(View $view, Response $response)
    {
        $this->view = $view;
        $this->response = $response;
    }

    public function index($request)
    {
        return $this->view->render($this->response, 'home.twig');
    }
}