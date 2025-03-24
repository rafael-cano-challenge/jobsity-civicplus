<?php

namespace App\Domain\Event\Entity;

class Event
{
    private $title;
    private $description;
    private $startDate;
    private $endDate;

    public function __construct(string $title, string $description, string $startDate, string $endDate)
    {
        $this->title = $title;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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
