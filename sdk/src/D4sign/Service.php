<?php

namespace D4sign;

class Service
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
