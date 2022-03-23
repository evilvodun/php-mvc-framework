<?php

namespace App\Providers;

use App\Auth\Auth;
use App\Views\View;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ViewShareServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{

    public function boot(): void
    {
        $container = $this->getContainer();

        $container->get(View::class)->share([
            'config' => $container->get('config'),
            'auth' => $container->get(Auth::class)
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
