<?php

return [
    'name' => env('APP_NAME'),
    'debug' => env('APP_DEBUG', false),

    'providers' => [
        'App\Providers\AppServiceProvider',
        'App\Providers\EnvironmentServiceProvider',
        'App\Providers\ResponseServiceProvider',
        'App\Providers\DatabaseServiceProvider',
        'App\Providers\SessionServiceProvider',
    ],

    'middlewares' => [
        'App\Middleware\ShareValidationErrors',
        'App\Middleware\ClearValidationErrors'
    ]
];