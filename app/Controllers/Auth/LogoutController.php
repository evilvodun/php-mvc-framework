<?php
namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Config\NamedRoutes;
use Laminas\Diactoros\Response;


class LogoutController
{
    public $response;
    public $auth;
    public $routes;

    public function __construct(Response $response, Auth $auth, NamedRoutes $routes)
    {
        $this->response = $response;
        $this->auth = $auth;
        $this->routes = $routes;
    }

    public function logout($request)
    {
        $this->auth->logout();

        return redirect($this->routes->getNameRoute('home'));
    }
}