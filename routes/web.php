<?php

$router->get('/', 'App\Controllers\HomeController::index')->setName('home');

$router->group('/auth', function($router){
    $router->get('/signin', 'App\Controllers\Auth\LoginController::index')->setName('auth.signin');
    $router->post('/signin', 'App\Controllers\Auth\LoginController::login');
});
