<?php

namespace App\Controllers\Auth;

use App\Views\View;
use League\Route\Router;
use App\Controllers\Controller;
use Laminas\Diactoros\Response;
use App\Session\SessionStoreInterface;

class LoginController extends Controller
{
    protected $view;
    protected $response;
    protected $session;

    public function __construct(View $view, Response $response, SessionStoreInterface $session)
    {
        $this->view = $view;
        $this->response = $response;
        $this->session = $session;
    }

    public function index($request)
    {
        // $errors = $this->session->get('errors', []);
        // $old = $this->session->get('old', []);


        
        return $this->view->render($this->response, 'auth/login.twig');
    }

    public function login($request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
    }
}
