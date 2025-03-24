<?php

namespace App\App\Routing;

use App\Application\Event\Dtos\EventDto;
use App\Middlewares\Middleware;
use App\Domain\Event\Entity\Event;
use App\Infrastructure\Clients\HttpClient;
use App\Infrastructure\Exceptions\NotFoundException;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    /**
     * Add a new route to the router.
     */
    public function add(string $method, string $path, array $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->normalizePath($path),
            'handler' => $handler,
            'pattern' => $this->buildPattern($path)
        ];
    }

    public function registerMiddlewares(array $middlewares): void
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);
    }

    /**
     * Dispatch the request to the right controller.
     */
    public function dispatch(HttpClient $client): array
    {
        $request = $this->parseRequest();

        $this->executeMiddlewares();

        foreach ($this->routes as $route) {
            if ($this->matchRoute($route, $request['method'], $request['uri'], $params)) {
                return $this->executeFunction($client, $route['handler'], $params, $request['body']);
            }
        }

        http_response_code(404);
        throw new NotFoundException('Route not found');
    }

    private function executeMiddlewares(): void
    {
        foreach ($this->middlewares as $middleware) {
            if (!class_exists($middleware)) {
                throw new \Exception("Middleware $middleware not found");
            }

            if (!method_exists($middleware, 'handle')) {
                throw new \Exception("Invalid middleware $middleware");
            }

            $middleware::handle();
        }
    }
    /**
     * Execute the controller method.
     */
    private function executeFunction(HttpClient $client, array $handler, array $params, array $body): array
    {
        [$controllerClass, $service, $repository, $method] = $handler;
        $hasBody = !empty($body);

        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller $controllerClass not found");
        }

        if (!method_exists($controllerClass, $method)) {
            throw new \Exception("Method $method not found in $controllerClass");
        }

        $controller = new $controllerClass();
        $eventDto = $hasBody ? EventDto::makeFromArray($body) : [];
        return $controller->$method(new $service(), new $repository($client), $params["id"] ?? "", $hasBody ? new Event($eventDto->getTitle(), $eventDto->getDescription(), $eventDto->getStartDate(), $eventDto->getEndDate()) : []);
    }

    private function matchRoute(array $route, string $method, string $uri, ?array &$params): bool
    {
        if ($route['method'] !== $method) {
            return false;
        }

        if (!preg_match($route['pattern'], $uri, $matches)) {
            return false;
        }

        $params = $this->extractParams($matches);
        return true;
    }

    private function normalizePath(string $path): string
    {
        return '/' . trim($path, '/');
    }

    private function buildPattern(string $path): string
    {
        $pattern = preg_replace('/\{(\w+)\}/', '(?<$1>[^\/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function extractParams(array $matches): array
    {
        return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
    }

    public function parseRequest(): array
    {
        return [
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'uri' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            'body' => json_decode(file_get_contents('php://input'), true) ?? []
        ];
    }
}
