<?php

namespace App\Providers;

use App\Views\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use \Twig\Extension\DebugExtension;
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

        $config = $container->get('config');

        $container->add(View::class, function() use ($config) {
            $loader = new FilesystemLoader(base_path('views'));

            $twig = new Environment($loader, [
                'cache' => $config->get('cache.views.path'),
                'debug' => $config->get('app.debug')
            ]);

            if($config->get('app.debug')) {
                $twig->addExtension(new DebugExtension());
            }

            return new View($twig);
        });

    }
}
