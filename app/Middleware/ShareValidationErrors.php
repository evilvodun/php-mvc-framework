<?php
namespace App\Middleware;

use App\Views\View;
use App\Session\SessionStoreInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


class ShareValidationErrors implements MiddlewareInterface
{
    protected $view;
    protected $session;
    
    public function __construct(View $view, SessionStoreInterface $session)
    {
        $this->view = $view;
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->view->share([
            'errors' => $this->session->get('errors', []),
            'old' => $this->session->get('old', []),
        ]);

        $response = $handler->handle($request);
        return $response;
    }

}