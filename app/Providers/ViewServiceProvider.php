<?php

namespace App\Providers;

use App\Views\View;
use Twig\Environment;
use Laminas\Diactoros\Response;
use Twig\Loader\FilesystemLoader;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ViewServiceProvider extends AbstractServiceProvider
{
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

        $container->add(View::class, function() use ($container) {
            $loader = new FilesystemLoader(__DIR__ . '/../../views');
            $twig = new Environment($loader, [
                'cache' => false
            ]);
            return new View($twig);
        });

    }
}
