<?php

namespace App\Providers;

use App\Auth\Auth;
use App\Views\View;
use Twig\Environment;
use League\Route\Router;
use App\Session\SessionStoreInterface;
use App\Views\Extensions\PathExtension;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ViewServiceProvider extends AbstractServiceProvider
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    public function provides(string $id): bool
    {
        $provides = [
            View::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(View::class, function() use ($container) {
            $twig = $container->get(Environment::class);

            $twig->addExtension(new PathExtension($this->router));

            return new View($twig);
        });

    }
}
