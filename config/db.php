<?php

return [
    'mysql' => [
        'driver' => env('DB_DRIVER', 'pdo_mysql'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'dbname' => env('DB_DATABASE', 'framework'),
        'user' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'h1fch13a'),
        'port' => env('DB_PORT', '3306'),
    ]
];