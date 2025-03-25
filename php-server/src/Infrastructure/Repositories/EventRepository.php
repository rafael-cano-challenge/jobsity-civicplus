<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Event\Entity\Event;
use App\UI\Http\Resources\ListTableDataResource;
use App\Domain\Event\Interfaces\EventClientInterface;
use App\Domain\Event\Interfaces\EventRepositoryInterface;
use App\Infrastructure\Exceptions\InvalidRequestException;

class EventRepository implements EventRepositoryInterface
{
    public $client;

    public function __construct(EventClientInterface $client)
    {
        $this->client = $client;
    }

    public function findAll(): array
    {
        try {
            $response = $this->client->get("Events");
            $contents = $response->getBody()->getContents();

            $data = json_decode($contents, true);

            $dataResource = new ListTableDataResource($data['items'], ['view_details']);

            return [
                'data' => $dataResource->toArray(),
                'current_page' => 1,
                'total' => count($data['items']),
                'per_page' => count($data['items']),
                'last_page' => 1,
            ];
        } catch (\Exception $e) {
            throw new InvalidRequestException("Failed getting all events");
        }
    }

    public function create(Event $event): array
    {
        try {
            $response = $this->client->post("Events", $event->toArray());
            $contents = $response->getBody()->getContents();

            return json_decode($contents, true);
        } catch (\Exception $e) {
            throw new InvalidRequestException("Failed creating event");
        }
    }

    public function findById(string $id): array
    {
        try {
            $response = $this->client->get("Events/" . $id);
            $contents = $response->getBody()->getContents();

            return json_decode($contents, true);
        } catch (\Exception $e) {
            throw new InvalidRequestException("Failed finding event by id");
        }
    }
}
