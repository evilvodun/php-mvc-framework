<?php

namespace App\Views\Extensions;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class ErrorsExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('errors', [$this, 'errors']),
        ];
    }

    public function errors($errors)
    {
        return $errors;
    }
}
