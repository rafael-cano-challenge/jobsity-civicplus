<?php

namespace App\Domain\Event\Interfaces;

use App\Domain\Event\Entity\Event;

interface EventRepositoryInterface
{
    public function findAll(): array;

    public function findById(string $id): array;

    public function create(Event $event): array;
}