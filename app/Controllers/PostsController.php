<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\Post;
use Laminas\Diactoros\Response;

class PostsController
{
    protected $view;

    protected $response;

    public function __construct(View $view, Response $response)
    {
        $this->view = $view;
        $this->response = $response;
    }

    public function index($request)
    {
        $posts = Post::paginate(10);

        return $this->view->render($this->response, 'posts/index.twig', compact('posts'));
    }
}
