<?php

namespace Tests\Unit;

use Exception;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\Domain\Event\Entity\Event;
use Psr\Http\Message\ResponseInterface;
use PHPUnit\Framework\MockObject\MockObject;
use App\UI\Http\Resources\ListTableDataResource;
use App\Infrastructure\Repositories\EventRepository;
use App\Domain\Event\Interfaces\EventClientInterface;
use App\Infrastructure\Exceptions\InvalidRequestException;
use PHPUnit\Framework\Attributes\UsesClass;

#[UsesClass(EventRepository::class)]
#[UsesClass(ListTableDataResource::class)]

class EventTest extends TestCase
{
    private MockObject|EventClientInterface $mockClient;
    private EventRepository $repository;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(EventClientInterface::class);
        $this->repository = new EventRepository($this->mockClient);
    }

    public function testFindAllSuccess(): void
    {
        $mockData = [
            'items' => [
                [
                    'id' => '1',
                    'title' => 'Event 1',
                    'description' => 'Description 1',
                    'startDate' => '2023-01-01',
                    'endDate' => '2023-01-02'
                ],
                [
                    'id' => '2',
                    'title' => 'Event 2',
                    'description' => 'Description 2',
                    'startDate' => '2023-02-01',
                    'endDate' => '2023-02-02'
                ]
            ],
            'total' => 2
        ];

        $this->mockClient->expects($this->once())
            ->method('get')
            ->with('Events')
            ->willReturn($this->createMockResponse($mockData));

        $result = $this->repository->findAll();

        $expectedResource = new ListTableDataResource($mockData['items'], ['view_details']);
        $this->assertEquals([
            'data' => $expectedResource->toArray(),
            'current_page' => 1,
            'total' => 2,
            'per_page' => 2,
            'last_page' => 1,
        ], $result);
    }

    public function testFindAllHandlesApiFailure(): void
    {
        $this->mockClient->expects($this->once())
            ->method('get')
            ->with('Events')
            ->willThrowException(new Exception('API Unavailable'));

        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessage('Failed getting all events');

        $this->repository->findAll();
    }

    public function testCreateEventSuccess(): void
    {
        $eventData = [
            'title' => 'New Event',
            'description' => 'Test Description',
            'startDate' => '2023-03-01',
            'endDate' => '2023-03-02'
        ];

        $event = new Event(
            $eventData['title'],
            $eventData['description'],
            $eventData['startDate'],
            $eventData['endDate']
        );

        $mockResponseData = ['id' => '3', ...$eventData];
        $this->mockClient->expects($this->once())
            ->method('post')
            ->with('Events', $event->toArray())
            ->willReturn($this->createMockResponse($mockResponseData));

        $result = $this->repository->create($event);

        $this->assertEquals($mockResponseData, $result);
    }

    public function testCreateHandlesApiFailure(): void
    {
        $event = new Event(
            'New Event',
            'Test Description',
            '2023-03-01',
            '2023-03-02'
        );

        $this->mockClient->expects($this->once())
            ->method('post')
            ->with('Events', $event->toArray())
            ->willThrowException(new Exception('Validation Error'));

        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessage('Failed creating event');

        $this->repository->create($event);
    }

    public function testFindByIdSuccess(): void
    {
        $eventId = '123';
        $mockData = [
            'id' => $eventId,
            'title' => 'Single Event',
            'description' => 'Event Description',
            'startDate' => '2023-04-01',
            'endDate' => '2023-04-02'
        ];

        $this->mockClient->expects($this->once())
            ->method('get')
            ->with("Events/{$eventId}")
            ->willReturn($this->createMockResponse($mockData));

        $result = $this->repository->findById($eventId);

        $this->assertEquals($mockData, $result);
    }

    public function testFindByIdHandlesNotFound(): void
    {
        $eventId = '999';

        $this->mockClient->expects($this->once())
            ->method('get')
            ->with("Events/{$eventId}")
            ->willThrowException(new Exception('Not Found'));

        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessage('Failed finding event by id');

        $this->repository->findById($eventId);
    }

    private function createMockResponse(array $data): ResponseInterface
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            Utils::streamFor(json_encode($data))
        );
    }
}
