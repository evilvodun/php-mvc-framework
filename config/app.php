<?php

return [
    'name' => env('APP_NAME'),
    'debug' => env('APP_DEBUG', false),

    'providers' => [
        'App\Providers\AppServiceProvider',
        'App\Providers\ResponseServiceProvider',
        'App\Providers\ViewServiceProvider',
    ]
];