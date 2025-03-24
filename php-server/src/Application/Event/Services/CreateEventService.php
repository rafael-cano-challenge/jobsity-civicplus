<?php

namespace App\Application\Event\Services;

use App\Domain\Event\Entity\Event;
use App\Domain\Event\Interfaces\EventRepositoryInterface;

class CreateEventService
{
    
    public function execute(EventRepositoryInterface $eventRepository, Event $event): array
    {
        return $eventRepository->create($event);
    }
}