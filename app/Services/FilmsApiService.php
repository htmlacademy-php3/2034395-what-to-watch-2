<?php

namespace App\Services;

use CurlHandle;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpFoundation\Response;

class FilmsApiService
{
    private CurlHandle $ch;
    private string $baseUrl = 'http://guide.phpdemo.ru/api';

    public function __construct()
    {
        $this->ch = curl_init();

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
    }

    /**
     * @param string $imdbId
     *
     * @return array
     */
    public function getFilm(string $imdbId): array
    {
        curl_setopt($this->ch, CURLOPT_URL, $this->baseUrl . "/films/$imdbId");

        $film = json_decode(curl_exec($this->ch), true);
        $error = curl_error($this->ch);

        abort_if($error, Response::HTTP_BAD_REQUEST, $error);

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
    }
}
