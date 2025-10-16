<?php
declare(strict_types=1);

namespace App;

use App\Core\Request;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $path, Request $request): void
    {
        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo "404 Not Found";

            return;
        }

        [$class, $classMethod] = $this->routes[$method][$path];

        $controller = new $class();

        $response = $controller->$classMethod($request);

        if ($response instanceof \App\Core\Response) {
            $response->send();
        } else {
            http_response_code(400);
            echo "400 Bad Request";

            return;
        }
    }
}