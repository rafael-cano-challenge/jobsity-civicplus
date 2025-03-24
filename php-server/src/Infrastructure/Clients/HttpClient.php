<?php

namespace App\Infrastructure\Clients;

use GuzzleHttp\Client;
use App\Domain\Event\Interfaces\EventClientInterface;

class HttpClient implements EventClientInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $url)
    {
        return $this->client->get($url);
    }

    public function post(string $url, array $data)
    {
        return $this->client->post($url, ['json' => $data]);
    }
}
