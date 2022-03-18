<?php
namespace App\Exceptions;

use Exception;
use ReflectionClass;

class Handler
{
    protected $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function respond()
    {
        $class = (new ReflectionClass($this->exception))->getShortName();

        if(method_exists($this, $method = "handle{$class}")) {
            return $this->{$method}($this->exception);
        }

        return $this->unhandledException($this->exception);
    }

    protected function handleValidationException($exception)
    {
        
        return redirect($exception->getPath());
    }

    protected function unhandledException($exception)
    {
        throw $exception;
    }
}