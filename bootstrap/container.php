<?php

use App\Providers\AppServiceProvider;
use App\Providers\ViewServiceProvider;
use App\Providers\ResponseServiceProvider;

$container = new League\Container\Container();

$container->delegate(
    new League\Container\ReflectionContainer()
);

$container->addServiceProvider(new AppServiceProvider());
$container->addServiceProvider(new ResponseServiceProvider());
$container->addServiceProvider(new ViewServiceProvider());
