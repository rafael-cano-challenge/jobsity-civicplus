<?php

namespace App\App\Middlewares;

use App\Infrastructure\Config\Config;

class CorsMiddleware
{
    public static function handle(): void
    {
        $allowedOrigin = Config::get('ALLOWED_ORIGIN');
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        header("Access-Control-Allow-Origin: $allowedOrigin");
        header('Access-Control-Allow-Credentials: true');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, Client-ID');
            header("Access-Control-Max-Age: 86400");
            exit;
        }

        if ($origin !== $allowedOrigin) {
            http_response_code(403);
            echo json_encode(['error' => 'Origin not allowed']);
            exit;
        }
    }
}
