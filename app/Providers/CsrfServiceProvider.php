<?php

namespace App\Providers;

use App\Security\Csrf;
use App\Session\SessionStoreInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CsrfServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $provides = [
            Csrf::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Csrf::class, function () use ($container) {
            return new Csrf(
                $container->get(SessionStoreInterface::class)
            );
        });
    }
}
