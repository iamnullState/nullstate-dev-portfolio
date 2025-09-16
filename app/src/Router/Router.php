<?php
declare(strict_types=1);

namespace Nullstate\Router;

final class Router
{
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $pattern, array $handler): void
    {
        $this->routes['GET'][$pattern] = $handler;
    }

    public function post(string $pattern, array $handler): void
    {
        $this->routes['POST'][$pattern] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        foreach ($this->routes[$method] ?? [] as $pattern => $handler) {
            $regex = "@^" . preg_replace('@\{([a-zA-Z_][a-zA-Z0-9_]*)\}@', '(?P<$1>[^/]+)', $pattern) . "$@";
            if (preg_match($regex, $uri, $matches)) {
                [$class, $methodName] = $handler;
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                (new $class())->{$methodName}(...$params);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}