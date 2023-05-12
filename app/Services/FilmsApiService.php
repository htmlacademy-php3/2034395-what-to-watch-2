<?php

namespace App\Services;

use CurlHandle;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class FilmsApiService
{
    private ClientInterface $client;

    private string $baseUrl = 'http://guide.phpdemo.ru/api';

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $imdbId
     *
     * @return array
     */
    public function getFilm(string $imdbId): array
    {
        try {
            $film = json_decode(
                $this->client->get("$this->baseUrl/films/$imdbId")->getBody()->getContents(),
                true
            );

            return [
                'name' => $film['name'],
                'poster_image' => $film['poster'],
                'preview_image' => $film['preview'],
                'background_image' => $film['background'],
                'video_link' => $film['video'],
                'description' => $film['desc'],
                'director' => $film['director'],
                'run_time' => $film['run_time'],
                'released' => $film['released'],
                'imdb_id' => $film['imdb_id'],
                'status' => 'moderate',
                'actors' => $film['actors'],
                'genres' => $film['genres'],
            ];
        } catch (GuzzleException $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }
}
