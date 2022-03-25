<?php


session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use League\Route\Router;


try {
    $dotenv = (Dotenv\Dotenv::createImmutable(base_path()))->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

require_once base_path('bootstrap/container.php');

$router = $container->get(Router::class);

$container->addServiceProvider(new App\Providers\ViewServiceProvider($router));
$container->addServiceProvider(new App\Providers\NamedRoutesServiceProvider($router));

require_once base_path('bootstrap/middleware.php');
require_once base_path('routes/web.php');

try {
    $response = $router->dispatch($container->get('request'));
} catch (\Exception $e) {
    $handler = new App\Exceptions\Handler(
        $e,
        $container->get(App\Session\SessionStoreInterface::class),
        $container->get(App\Views\View::class),
        $container->get(Laminas\Diactoros\Response::class)
    );
    $response = $handler->respond();
}
