<?php

$router->map('GET', '/', 'App\Controllers\HomeController::index')->setName('home');

$router->group('', function ($router) {
    $router->map('GET', '/dashboard', 'App\Controllers\DashboardController::index')->setName('dashboard');
    $router->post('/auth/logout', 'App\Controllers\Auth\LogoutController::logout')->setName('auth.logout');
})->middleware($container->get(App\Middleware\Dashboard\Authenticated::class));

$router->group('', function ($router) {
    $router->get('/auth/signin', 'App\Controllers\Auth\LoginController::index')->setName('auth.signin');
    $router->post('/auth/signin', 'App\Controllers\Auth\LoginController::login');
    $router->get('/auth/register', 'App\Controllers\Auth\RegisterController::index')->setName('auth.register');
    $router->post('/auth/register', 'App\Controllers\Auth\RegisterController::register');
})->middleware($container->get(App\Middleware\Guest::class));
