<?php

namespace Patrickjunod\Matomic\Client;

use Illuminate\Support\Facades\Http;

class MatomicClient
{
    protected $url;
    protected $token;
    protected string $format = 'json';

    public function __construct($url, $token)
    {
        $this->url = $url;
        $this->token = $token;

        return $this;
    }

    public function callApi($method, $arguments = [])
    {
        return $this->call('API', $method, $arguments);
    }

    public function call($module, $method, $arguments = [])
    {
        $parameters = [
            'module' => $module,
            'method' => $method,
            'format' => $this->format,
            'token_auth' => $this->token,
        ];

        $parameters = array_merge($parameters, $arguments);

        $response = Http::get($this->url, $parameters);

        return $response->json();
    }

    public function getModule($name)
    {
        return new Module($this, $name);
    }
}
