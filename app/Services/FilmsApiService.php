<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;

class FilmsApiService
{
    public function __construct(
        private readonly ClientInterface $client = new Client(['base_url' => 'http://guide.phpdemo.ru']),
    ) {
    }

    /**
     * @param string $imdbId
     *
     * @return array
     */
    public function getFilm(string $imdbId): array
    {
        try {
            $film = $this->client->get("/api/films/$imdbId");

            return json_decode($film->getBody()->getContents());
        } catch (GuzzleException $error) {
            abort($error->getCode(), $error->getMessage());
        }
    }
}
