<?php

namespace Patrickjunod\Matomic\Client;

class Module
{
    protected $name;
    protected $client;

    public function __construct(MatomicClient $client, $name)
    {
        $this->client = $client;
        $this->name = $name;
    }

    public function __call($name, $arguments)
    {
        $args = [];
        if (isset($arguments[0])) {
            $args = $arguments[0];
        }
        return $this->client->callApi($this->name . '.' . $name, $args);
    }
}
