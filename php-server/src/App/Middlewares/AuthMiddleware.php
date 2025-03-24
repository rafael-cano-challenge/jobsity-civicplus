<?php

namespace App\App\Middlewares;

use App\Infrastructure\Config\Config;

class AuthMiddleware
{
    public static function handle(): void
    {
        $clientId = $_SERVER['HTTP_CLIENT_ID'] ?? null;
        $validClient = Config::get('CLIENT_ID');

        if (!$clientId || $clientId !== $validClient) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid client credentials']);
            exit;
        }
    }
}
