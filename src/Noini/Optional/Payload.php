<?php

namespace Noini\Optional;

class Payload
{
    private $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    public function isNull(): bool
    {
        return $this->payload === null;
    }
}