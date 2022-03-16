<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\User;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response;

class HomeController 
{
    protected $view;
    protected $response;
    protected $db;
    
    public function __construct(View $view, Response $response, EntityManager $db)
    {
        $this->view = $view;
        $this->response = $response;
        $this->db = $db;
    }

    public function index($request)
    {
        $user = $this->db->getRepository(User::class)->find(1);

        return $this->view->render($this->response, 'home.twig', [
            'user' => $user
        ]);
    }
}