<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Views\View;
use Laminas\Diactoros\Response;

class LoginController extends Controller
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
