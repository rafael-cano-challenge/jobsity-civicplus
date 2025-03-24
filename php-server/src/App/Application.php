<?php

namespace App\App;

use GuzzleHttp\Client;
use App\App\Middlewares\CorsMiddleware;
use App\App\Middlewares\AuthMiddleware;
use App\App\Routing\Router;
use App\Infrastructure\Config\Config;
use App\Infrastructure\Clients\HttpClient;
use App\UI\Http\Controllers\EventController;
use App\Infrastructure\Repositories\EventRepository;
use App\Application\Event\Services\CreateEventService;
use App\Application\Event\Services\ListAllEventService;
use App\Application\Event\Services\SeeDetailsEventService;

class Application
{
    private Router $router;

    public function __construct() {}

    /**
     * Run the application.
     */
    public function run(): void
    {
        try {
            $this->initializeRouter();
            $client = $this->initializeHttpClient();
            $response = $this->router->dispatch($client);

            $this->sendResponse($response);
        } catch (\Exception $e) {
            $this->sendResponse(['error' => $e->getMessage()]);
        }
    }

    /**
     * Initialize the router and register the routes.
     */
    private function initializeRouter(): void
    {
        $this->router = new Router();
        $this->registerRoutes();

        $this->router->registerMiddlewares([
            CorsMiddleware::class,
            AuthMiddleware::class
        ]);
    }
    /**
     * Allowed routes for the application.
     */
    private function registerRoutes(): void
    {
        $this->router->add('GET', '/api/events', [EventController::class, ListAllEventService::class, EventRepository::class, 'findAll']);
        $this->router->add('POST', '/api/events', [EventController::class, CreateEventService::class, EventRepository::class, 'create']);
        $this->router->add('GET', '/api/events/{id}', [EventController::class, SeeDetailsEventService::class, EventRepository::class, 'findById']);
    }

    private function sendResponse(array $response): void
    {
        header('Content-Type: application/json');
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    private function initializeHttpClient()
    {
        return new HttpClient(new Client([
            'base_uri' => Config::get('API_URL'),
            'headers' => [
                'Authorization' => 'Bearer ' . Config::get('ACCESS_TOKEN'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]));
    }
}
