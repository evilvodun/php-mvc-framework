<?php

namespace App\Providers;

use App\Config\Config;
use App\Config\Loaders\ArrayLoader;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ConfigServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $provides = [
            'config'
        ];

        return in_array($id, $provides);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->add('config', function(){
            $loader = new ArrayLoader([
                'app' => base_path('config/app.php'),
                'cache' => base_path('config/cache.php')
            ]);

            return (new Config())->load([$loader]);
        });
    }
}
