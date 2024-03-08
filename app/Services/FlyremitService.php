<?php
// app/Services/FlyremitService.php

namespace App\Services;

use GuzzleHttp\Client;

class FlyremitService
{
    protected $client;
    protected $apiKey;
    protected $baseUri;

    public function __construct($apiKey, $baseUri)
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
        ]);
        $this->apiKey = $apiKey;
    }

    public function registerAgent($dmcId, $agentId, $panNumber, $name, $mobile, $email, $cityId)
    {
        $endpoint = 'https://apitest.flyremit.com/api/JWTLoginAuthentication';

        $response = $this->makeRequest('POST', $endpoint, [
            'dmcid' => $dmcId,
            'agnetID' => $agentId,
            'panNumber' => $panNumber,
            'name' => $name,
            'mobile' => $mobile,
            'email' => $email,
            'cityId' => $cityId,
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function makeRequest($method, $endpoint, $data = [])
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];

        $options = [
            'headers' => $headers,
            'json' => $data,
        ];

        return $this->client->request($method, $endpoint, $options);
    }
}

