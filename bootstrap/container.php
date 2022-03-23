<?php

$container = new League\Container\Container();

$container->delegate(
    new League\Container\ReflectionContainer()
);

$container->addServiceProvider(new App\Providers\ConfigServiceProvider());
$container->addServiceProvider(new App\Providers\AppServiceProvider());

foreach ($container->get('config')->get('app.providers') as $provider) {
    $container->addServiceProvider(new $provider);
}

