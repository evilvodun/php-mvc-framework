<?php

namespace App\Config;

use App\Config\Loaders\LoaderInterface;

class Config
{
    protected $config = [];
    protected $cache = [];

    public function load(array $loaders)
    {
        foreach ($loaders as $loader) {
            if(!$loader instanceof LoaderInterface) {
                continue;
            }

            $this->config = array_merge($this->config, $loader->parse());
        }

        return $this;
    }

    public function get($key, $default = null)
    {
        if($this->existsInCache($key)) {
            return $this->fromCache($key);
        }

        return $this->addToCache(
            $key, 
            $this->extractFromConfig($key) ?? $default
        );
    }

    protected function extractFromConfig($key)
    {
        $filtered = $this->config;

        foreach (explode('.', $key) as $segment) {
            if ($this->exists($filtered, $segment)) {
                $filtered = $filtered[$segment];
                continue;
            }
            return;
        }

        return $filtered;
    }

    public function addToCache($key, $value)
    {
        $this->cache[$key] = $value;
        
        return $value;
    }

    protected function existsInCache($key)
    {
        return isset($this->cache[$key]);
    }

    protected function fromCache($key)
    {
        return $this->cache[$key]; 
    }

    public function exists(array $config, $key)
    {
        return array_key_exists($key, $config);
    }
}