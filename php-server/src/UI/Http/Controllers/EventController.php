<?php

namespace App\UI\Http\Controllers;

use App\Domain\Event\Entity\Event;
use App\Application\Event\Services\CreateEventService;
use App\Application\Event\Services\ListAllEventService;
use App\Application\Event\Services\SeeDetailsEventService;
use App\Domain\Event\Interfaces\EventRepositoryInterface;

class EventController
{
    public function findAll(ListAllEventService $listAllEventService, EventRepositoryInterface $eventRepository)
    {
        return $listAllEventService->execute($eventRepository);
    }

    public function create(CreateEventService $createEventService, EventRepositoryInterface $eventRepository, string $id, Event $event)
    {
        return $createEventService->execute($eventRepository, $event);
    }

    public function findById(SeeDetailsEventService $seeDetailsEventService, EventRepositoryInterface $eventRepository, string $id)
    {
        return $seeDetailsEventService->execute($eventRepository, $id);
    }
}
