<?php

namespace App\Application\Event\Dtos;

class EventDto
{
    private $title;
    private $description;
    private $startDate;
    private $endDate;

    public static function makeFromArray(array $params)
    {
        $eventDto = new self();
        foreach ($params as $key => $value) {
            if (property_exists($eventDto, $key)) {
                $eventDto->$key = $value;
            }
        }
        return $eventDto;
    }

    public static function makeFromRequest(array $response)
    {
        $result = [];
        foreach ($response as $key => $object) {
            array_push($result, self::makeFromArray((array) $object));
        }
        return $result;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }
}
