<?php

foreach($container->get('config')->get('app.middlewares') as $middleware) {
    $router->middleware($container->get($middleware));
}
