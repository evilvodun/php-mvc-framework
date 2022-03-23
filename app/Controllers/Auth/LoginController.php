<?php

namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Views\View;
use League\Route\Router;
use App\Config\NamedRoutes;
use App\Controllers\Controller;
use Laminas\Diactoros\Response;
use App\Session\SessionStoreInterface;

class LoginController extends Controller
{
    protected $view;
    protected $response;
    protected $session;
    protected $auth;
    protected $routes;

    public function __construct(
        View $view,
        Response $response,
        SessionStoreInterface $session,
        Auth $auth,
        NamedRoutes $routes
    ) {
        $this->view = $view;
        $this->response = $response;
        $this->session = $session;
        $this->auth = $auth;
        $this->routes = $routes;
    }

    public function index($request)
    {
        return $this->view->render($this->response, 'auth/login.twig');
    }

    public function login($request)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attempt = $this->auth->attempt($data['email'], $data['password']);

        if(!$attempt) {
            dd('failed');
        }

        return redirect($this->routes->getNameRoute('home'));
    }
}
