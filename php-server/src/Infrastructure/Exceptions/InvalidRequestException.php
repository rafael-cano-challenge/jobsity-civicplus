<?php

namespace App\Infrastructure\Exceptions;

class InvalidRequestException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}