<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilmsController extends Controller
{
    public function getAll(?int $page, ?string $genre, ?string $status, ?string $orderBy, ?string $orderTo): array
    {
        return [];
    }

    public function get(int $id): array
    {
        return [];
    }

    public function getFavorite(int $userId): array
    {
        return [];
    }

    public function addToFavorite(int $filmId, string $status): void
    {

    }

    public function deleteFromFavorite(int $filmId): void
    {

    }

    public function similar(int $id): array
    {
        return [];
    }

    public function add(string $imdbId): void
    {

    }

    public function change(
        int     $id,
        ?string $name,
        ?string $posterImageUrl,
        ?string $previewImageUrl,
        ?string $bgImageUrl,
        ?string $bgColor,
        ?string $videoLink,
        ?string $previewVideoLink,
        ?string $description,
        ?string $director,
        ?array  $starring,
        ?string $genre,
        ?int    $runTime,
        ?int    $released,
        ?string $imdbId,
        ?string $status
    ): void
    {

    }
}
