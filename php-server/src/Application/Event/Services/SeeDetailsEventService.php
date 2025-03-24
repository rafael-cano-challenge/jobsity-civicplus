<?php

namespace App\Application\Event\Services;

use App\Domain\Event\Interfaces\EventRepositoryInterface;

class SeeDetailsEventService
{
    
    public function execute(EventRepositoryInterface $eventRepository, string $id): array
    {
        return $eventRepository->findById($id);
    }
}