<?php

namespace App\Providers;

use App\Cookie\CookieJar;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CookieServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        $provides = [
            CookieJar::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(CookieJar::class, function () use ($container) {
            return new CookieJar();
        });
    }
}
