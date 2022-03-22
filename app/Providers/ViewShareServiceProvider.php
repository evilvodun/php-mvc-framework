<?php

namespace App\Providers;

use App\Views\View;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ViewShareServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{

    public function boot(): void
    {
        $container = $this->getContainer();

        $container->get(View::class)->share([
            'config' => $container->get('config')
        ]);
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
