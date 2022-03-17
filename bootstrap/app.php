<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = (Dotenv\Dotenv::createImmutable(base_path()))->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

require_once __DIR__ . '/container.php';

$strategy = (new League\Route\Strategy\ApplicationStrategy)->setContainer($container);
$router   = (new League\Route\Router)->setStrategy($strategy);

require_once base_path('routes/web.php');

try {
    $response = $router->dispatch($container->get('request'));
} catch (\Exception $e) {
    dump($e);
}
