<?php

namespace App\Controllers;

use App\Views\View;
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

    public function index()
    {
        // $this->response->getBody()->write('hello world');
        // return $this->response;
        return $this->view->render();
    }
}