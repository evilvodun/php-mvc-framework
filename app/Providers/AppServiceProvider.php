<?php
namespace App\Providers;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $provides = [
            'request',
            'emitter',
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->add('request', function(){
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });
        
        $container->add('emitter', SapiEmitter::class);
    }
}