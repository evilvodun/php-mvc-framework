<?php

namespace App\Views\Extensions;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class ConfigExtension extends AbstractExtension
{
    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('config', [$this, 'config']),
        ];
    }

    public function config()
    {
        return $this->config;
    }
}
