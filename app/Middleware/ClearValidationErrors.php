<?php

namespace App\Middleware;

use Twig\Environment;
use App\Session\SessionStoreInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Views\Extensions\ErrorsExtension;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


class ClearValidationErrors implements MiddlewareInterface
{
    protected $session;

    public function __construct(SessionStoreInterface $session)
    {
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        
        $this->session->clear('errors', 'old');

        return $response;
    }
}
