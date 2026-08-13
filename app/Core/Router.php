<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(
        string $method,
        string $path,
        string $controller,
        string $action
    ): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {

            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = preg_replace(
                '#\{[^}]+\}#',
                '([0-9]+)',
                $route['path']
            );

            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {

                array_shift($matches);

                $controller = new $route['controller'](
                    new \App\Services\UserService(
                        new \App\Repositories\UserRepository(
                            new Database()
                        )
                    )
                );

                $controller->{$route['action']}(...$matches);

                return;
            }
        }

        http_response_code(404);

        echo json_encode([
            'error' => 'Route not found'
        ]);
    }
}