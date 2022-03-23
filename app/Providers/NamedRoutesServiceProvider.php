<?php

namespace App\Providers;

use Twig\Environment;
use League\Route\Router;
use App\Config\NamedRoutes;
use League\Container\ServiceProvider\AbstractServiceProvider;

class NamedRoutesServiceProvider extends AbstractServiceProvider
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function provides(string $id): bool
    {
        $provides = [
            NamedRoutes::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(NamedRoutes::class, function () use ($container) {
            $twig = $container->get(Environment::class);
            
            return new NamedRoutes($this->router);
        });
    }
}
