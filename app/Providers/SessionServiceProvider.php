<?php

namespace App\Providers;

use App\Session\Session;
use App\Session\SessionStoreInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class SessionServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $provides = [
            SessionStoreInterface::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->add(SessionStoreInterface::class, function(){
            return new Session();
        });
    }
}
