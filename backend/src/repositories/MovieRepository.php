<?php

namespace Mentalaffect\WhatToWatch\repositories;

use Mentalaffect\WhatToWatch\repositories\interfaces\MovieRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\ClientInterface;

class MovieRepository implements MovieRepositoryInterface
{
    private Client $client;
    private string $key;
    private const API_URI = 'https://www.omdbapi.com/';

    public function __construct(ClientInterface $httpClient, string $key)
    {
        $this->client = $httpClient;
        $this->key = $key;
    }

    /**
     * Returns array with requested by IMDB id movie params
     *
     * @param string $id IMDB id
     * @return array Movie params
     *
     * @throws GuzzleException
     */
    public function getById(string $id): array
    {
        $response = $this->client->request('GET', self::API_URI, [
            'query' => [
                'apikey' => $this->key,
                'i' => $id
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}