<?php

namespace App\Services;

use HttpRequestException;
use Illuminate\Support\Facades\Http;

class FilmsApiService
{
    private string $baseUrl = 'http://guide.phpdemo.ru/api';

    public function __construct()
    {
    }

    /**
     * @param string $imdbId
     *
     * @return array
     */
    public function getFilm(string $imdbId): array
    {
        try {
            $response = Http::get("$this->baseUrl/films/$imdbId");

            if (!$response->successful()) {
                throw new HttpRequestException("Request failed");
            }

            $film = json_decode(
                $response->body(),
                true
            );

            return [
                'film' => [
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
                ],
                'actors' => $film['actors'],
                'genres' => $film['genres'],
            ];
        } catch (HttpRequestException $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }
}
