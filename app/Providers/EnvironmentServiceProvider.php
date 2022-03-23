<?php

namespace App\Providers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use League\Container\ServiceProvider\AbstractServiceProvider;
use \Twig\Extension\DebugExtension;

class EnvironmentServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        $provides = [
            Environment::class
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $config = $container->get('config');

        $container->addShared(Environment::class, function () use ($config, $container) {
            $loader = new FilesystemLoader(base_path('views'));
            $twig = new Environment($loader, [
                'cache' => $config->get('cache.views.path'),
                'debug' => $config->get('app.debug')
            ]);

            if ($config->get('app.debug')) {
                $twig->addExtension(new DebugExtension());
            }
            return $twig;            
        });
    }
}
