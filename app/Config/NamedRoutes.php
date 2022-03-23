<?php
namespace App\Config;


class NamedRoutes
{
    protected $router;

    public function __construct($router)
    {
        $this->router = $router;
    }
    
    public function getNameRoute($route)
    {
        return $this->router->getNamedRoute($route)->getPath();
    }
}