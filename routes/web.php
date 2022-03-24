<?php

$router->map('GET', '/', 'App\Controllers\HomeController::index')->setName('home');

$router->group('', function($router){
    $router->map('GET', '/dashboard', 'App\Controllers\DashboardController::index')->setName('dashboard');
})->middleware($container->get(App\Middleware\Dashboard\Authenticated::class));


$router->group('/auth', function($router){
    $router->get('/signin', 'App\Controllers\Auth\LoginController::index')->setName('auth.signin');
    $router->post('/signin', 'App\Controllers\Auth\LoginController::login');

    $router->post('/logout', 'App\Controllers\Auth\LogoutController::logout')->setName('auth.logout');

    $router->get('/register', 'App\Controllers\Auth\RegisterController::index')->setName('auth.register');
    $router->post('/register', 'App\Controllers\Auth\RegisterController::register');
});
