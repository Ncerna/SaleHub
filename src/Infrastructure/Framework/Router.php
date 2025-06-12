<?php
namespace App\Infrastructure\Framework;

class Router
{
    private $routes = [];

    public function addRoute(string $method, string $path, callable $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method][$path])) {
            call_user_func($this->routes[$method][$path]);
        } else {
            http_response_code(404);
            echo "404 Not Found - Ruta no encontrada";
        }
    }
}

use GuzzleHttp\Psr7\ServerRequest;

public function dispatch(): void
{
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if (isset($this->routes[$method][$path])) {
        $request = ServerRequest::fromGlobals();
        call_user_func($this->routes[$method][$path], $request);
    } else {
        http_response_code(404);
        echo "404 Not Found - Ruta no encontrada";
    }
}
