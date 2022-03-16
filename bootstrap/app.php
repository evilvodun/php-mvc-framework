<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = (Dotenv\Dotenv::createImmutable(__DIR__ . '/..//'))->load();

require_once __DIR__ . '/container.php';

$strategy = (new League\Route\Strategy\ApplicationStrategy)->setContainer($container);
$router   = (new League\Route\Router)->setStrategy($strategy);

require_once __DIR__ . '/../routes/web.php';

$response = $router->dispatch($container->get('request'));
