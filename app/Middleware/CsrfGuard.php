<?php

namespace App\Middleware;

use App\Security\Csrf;
use App\Exceptions\CsrfTokenException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


class CsrfGuard implements MiddlewareInterface
{
    protected $csrf;

    public function __construct(Csrf $csrf)
    {
        $this->csrf = $csrf;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->requestRequiresProtection($request)) {
            return $handler->handle($request);
        }

        if (!$this->csrf->tokenIsValid($this->getTokenFromRequest($request))) {
            throw new CsrfTokenException();
        }

        return $handler->handle($request);
    }

    protected function requestRequiresProtection($request)
    {
        return in_array($request->getMethod(), ['POST', 'DELETE', 'PUT', 'PATCH']);
    }

    protected function getTokenFromRequest($request)
    {
        return $request->getParsedBody()[$this->csrf->key()] ?? null;
    }
}
