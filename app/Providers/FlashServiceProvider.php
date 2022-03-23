<?php

namespace App\Providers;

use App\Session\Flash;
use App\Session\SessionStoreInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class FlashServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        $provides = [
            Flash::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Flash::class, function () use ($container) {
            return new Flash(
                $container->get(SessionStoreInterface::class)
            );
        });
    }
}
