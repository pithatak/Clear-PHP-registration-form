<?php
declare(strict_types=1);

namespace App;

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

    public function dispatch(string $method, string $path): mixed
    {

        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);

            echo "404 Not Found";

            exit();
        }

        [$class, $classMethod] = $this->routes[$method][$path];

        return call_user_func([new $class, $classMethod]);
    }
}