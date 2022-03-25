<?php

namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Views\View;
use App\Models\User;
use App\Config\NamedRoutes;
use App\Controllers\Controller;
use Laminas\Diactoros\Response;
use App\Auth\Hashing\HasherInterface;

class RegisterController extends Controller
{
    protected $view;
    protected $response;
    protected $hash;
    protected $routes;

    protected $auth;

    public function __construct(
        View $view,
        Response $response,
        HasherInterface $hash,
        NamedRoutes $routes,
        Auth $auth
    ) {
        $this->view = $view;
        $this->response = $response;
        $this->hash = $hash;
        $this->routes = $routes;
        $this->auth = $auth;
    }

    public function index($request)
    {
        return $this->view->render($this->response, 'auth/register.twig');
    }

    public function register($request)
    {
        $data = $this->validateRegistration($request);
        $user = $this->createUser($data);

        if(!$this->auth->attempt($data['email'], $data['password'])) {
            return redirect($this->routes->getNameRoute('auth.signin'));
        }

        return redirect($this->routes->getNameRoute('home'));
    }

    protected function createUser($data)
    {

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $this->hash->create($data['password'])
        ]);
    }

    protected function validateRegistration($request)
    {
        return $this->validate($request, [
            'email' => ['required', 'email', ['exists', User::class]],
            'name' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required', ['equals', 'password']],
        ]);
    }
}
