<?php

namespace App\Application\Event\Services;

use App\Domain\Event\Interfaces\EventRepositoryInterface;

class ListAllEventService
{

    public function execute(EventRepositoryInterface $eventRepository): array
    {
        return $eventRepository->findAll();
    }

}