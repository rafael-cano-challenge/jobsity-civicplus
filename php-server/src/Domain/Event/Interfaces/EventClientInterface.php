<?php

namespace App\Domain\Event\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface EventClientInterface
{
    public function get(string $url);
    public function post(string $url, array $data);
}