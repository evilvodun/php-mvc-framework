<?php

namespace App\Exceptions;

use Exception;
use ReflectionClass;
use App\Session\SessionStoreInterface;

class Handler
{
    protected $exception;
    protected $session;

    public function __construct(
        Exception $exception,
        SessionStoreInterface $session
    ) {
        $this->exception = $exception;
        $this->session = $session;
    }

    public function respond()
    {
        $class = (new ReflectionClass($this->exception))->getShortName();

        if (method_exists($this, $method = "handle{$class}")) {
            return $this->{$method}($this->exception);
        }

        return $this->unhandledException($this->exception);
    }

    protected function handleValidationException($exception)
    {
        $this->session->set([
            'errors' => $exception->getErrors(),
            'old' => $exception->getOldInput()
        ]);

        return redirect($exception->getPath());
    }

    protected function unhandledException($exception)
    {
        throw $exception;
    }
}
