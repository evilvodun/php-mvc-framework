<?php

namespace App\Providers;

use App\Auth\Hashing\BcryptHasher;
use App\Auth\Hashing\HasherInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class HashServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        $provides = [
            HasherInterface::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(HasherInterface::class, function () {
            return new BcryptHasher;
        });
    }
}
