<?php

use App\Views\View;
use App\Views\Extensions\PathExtension;
use League\Route\Strategy\ApplicationStrategy;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = (Dotenv\Dotenv::createImmutable(base_path()))->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

require_once base_path('bootstrap/container.php');

$strategy = (new ApplicationStrategy)->setContainer($container);
$router = $container->get(League\Route\Router::class)->setStrategy($strategy);

require_once base_path('bootstrap/middleware.php');

require_once base_path('routes/web.php');

$container->addServiceProvider(new App\Providers\ViewServiceProvider($router));

try {
    $response = $router->dispatch($container->get('request'));
} catch (\Exception $e) {
    $handler = new App\Exceptions\Handler(
        $e, 
        $container->get(App\Session\SessionStoreInterface::class)
    );
    $response = $handler->respond();
}

