<?php

return [
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'database' => env('DB_DATABASE', 'framework'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'h1fch13a'),
        'port' => env('DB_PORT', '3306'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ]
];