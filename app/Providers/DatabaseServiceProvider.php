<?php

namespace App\Providers;


use Illuminate\Database\Capsule\Manager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class DatabaseServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void
    {
        $container = $this->getContainer();

        $config = $container->get('config');

        $capsule = new Manager();
        $capsule->addConnection($config->get('db.' . env('DB_TYPE')));

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function provides(string $id): bool
    {
        return false;
    }

    public function register(): void
    {
        // ...
    }
}
