<?php

namespace App\Providers;

use App\Rules\ExistsRule;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Valitron\Validator;

class ValidationServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{

    public function boot(): void
    {
        $container = $this->getContainer();

        Validator::addRule('exists', function ($field, $value, $params, $fields) {
            $rule = new ExistsRule();

            return $rule->validate($field, $value, $params, $fields);

        }, 'is already in use!');
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
