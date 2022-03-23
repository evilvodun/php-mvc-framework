<?php

namespace App\Providers;

use League\Route\Router;
use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Strategy\ApplicationStrategy;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $provides = [
            'request',
            'emitter',
            Router::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared('request', function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $_FILES
            );
        });

        $container->addShared(Router::class, function () use ($container) {

            $strategy = (new ApplicationStrategy)->setContainer($container);
            $router = (new Router)->setStrategy($strategy);
            
            return $router;
        });

        $container->addShared('emitter', SapiEmitter::class);
    }
}
