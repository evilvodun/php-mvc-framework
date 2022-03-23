<?php

namespace App\Exceptions;

use Exception;
use App\Views\View;
use ReflectionClass;
use Psr\Http\Message\ResponseInterface;
use App\Session\SessionStoreInterface;

class Handler
{
    protected $exception;
    protected $session;
    protected $view;
    protected $response;

    public function __construct(
        Exception $exception,
        SessionStoreInterface $session,
        View $view,
        ResponseInterface $response
    ) {
        $this->exception = $exception;
        $this->session = $session;
        $this->view = $view;
        $this->response = $response;
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

    protected function handleCsrfTokenException($exception)
    {
        return $this->view->render($this->response, 'errors/csrf.twig');
    }

    protected function unhandledException($exception)
    {
        throw $exception;
    }
}
