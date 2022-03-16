<?php

namespace App\Views;

use Twig\Environment;
use Laminas\Diactoros\Response;

class View 
{
    protected $twig;
    protected $response;

    public function __construct(Environment $twig, Response $response)
    {
        $this->twig = $twig;
        $this->response = $response;
    }

    public function render()
    {
        $this->response->getBody()->write('hello world');
        return $this->response;
    }
}