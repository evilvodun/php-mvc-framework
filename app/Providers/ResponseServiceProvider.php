<?php

namespace App\Providers;

use Laminas\Diactoros\Response;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ResponseServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $provides = [
            Response::class,
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();
        $container->add(Response::class, function(){
            return new Response;
        });
    }
}
