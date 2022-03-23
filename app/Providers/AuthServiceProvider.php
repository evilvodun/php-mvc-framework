<?php

namespace App\Providers;

use App\Auth\Auth;
use Doctrine\ORM\EntityManager;
use App\Auth\Hashing\HasherInterface;
use App\Session\SessionStoreInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AuthServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $provides = [
            Auth::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Auth::class, function () use ($container){
            return new Auth(
                $container->get(EntityManager::class),
                $container->get(HasherInterface::class),
                $container->get(SessionStoreInterface::class)
            );
        });
    }
}
