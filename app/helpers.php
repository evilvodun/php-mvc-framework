<?php

if (!function_exists('redirect')) {
    function redirect($path)
    {
        return new Laminas\Diactoros\Response\RedirectResponse($path);
    }
}

if(!function_exists('base_path')) {
    function base_path($path = '')
    {
        return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if(!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = $_ENV[$key];

        if($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case $value === 'true':
                return true;
            case $value === 'false':
                return false;
            default:
                return $value;
        }
    }
}