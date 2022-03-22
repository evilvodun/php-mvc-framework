<?php
namespace App\Middleware;

use Twig\Environment;
use App\Session\SessionStoreInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Views\Extensions\ErrorsExtension;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


class ShareValidationErrors implements MiddlewareInterface
{
    protected $twig;
    protected $session;
    
    public function __construct(Environment $twig, SessionStoreInterface $session)
    {
        $this->twig = $twig;
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    { 
        // $this->twig->addGlobal('errors', $this->session->get('errors', []));
        // $this->twig->addExtension(new ErrorsExtension($this->session->get('errors', [])));
        

        $response = $handler->handle($request);
        return $response;
    }

}