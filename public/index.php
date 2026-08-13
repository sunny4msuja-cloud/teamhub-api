<?php

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');

$router = new App\Core\Router();

$routes = require __DIR__ . '/../routes/api.php';

foreach ($routes as $path => $route) {
    [$method, $url] = explode(' ', $path, 2);

    $router->add(
        $method,
        $url,
        $route['controller'],
        $route['method']
    );
}

$router->dispatch();