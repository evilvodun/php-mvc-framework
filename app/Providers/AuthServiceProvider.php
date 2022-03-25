<?php

namespace App\Providers;

use App\Auth\Auth;
use App\Auth\Recaller;
use App\Cookie\CookieJar;
use Doctrine\ORM\EntityManager;
use App\Auth\Hashing\HasherInterface;
use App\Auth\Providers\DatabaseProvider;
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
            $provider = new DatabaseProvider(
                $container->get(EntityManager::class)
            );

            return new Auth(
                $container->get(HasherInterface::class),
                $container->get(SessionStoreInterface::class),
                new Recaller(),
                $container->get(CookieJar::class),
                $provider
            );
        });
    }
}
