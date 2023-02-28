<?php

namespace Mentalaffect\WhatToWatch\repositories;

use Mentalaffect\WhatToWatch\repositories\interfaces\MovieRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\ClientInterface;

class MovieRepository implements MovieRepositoryInterface
{
    private Client $client;
    private const API_KEY = '1b16dec1';
    private const API_URI = 'https://www.omdbapi.com/';

    public function __construct(ClientInterface $httpClient)
    {
        $this->client = $httpClient;
    }

    public function all(): array
    {
        return [];
    }

    public function getById(string $id): array
    {
        try {
            $response = $this->client->request('GET', self::API_URI, [
                'query' => [
                    'apikey' => self::API_KEY,
                    'i' => $id
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            print($e->getMessage());
            die();
        }
    }
}