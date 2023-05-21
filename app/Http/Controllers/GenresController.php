<?php

namespace App\Http\Controllers;

use App\Http\Requests\Genres\AddGenreRequest;
use App\Http\Requests\Genres\ChangeGenreRequest;
use App\Http\Responses\Success;
use App\Models\Genre;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GenresController extends Controller
{
    public function getAll(Request $request): Response
    {
        $genres = Genre::query()->get()->all();

        return (new Success($genres))->toResponse($request);
    }

    public function add(AddGenreRequest $request): Response
    {
        $genre = Genre::query()->create($request->post());

        return (new Success($genre, Response::HTTP_CREATED))->toResponse($request);
    }

    public function change(ChangeGenreRequest $request, Genre $genre): Response
    {
        $genre->update($request->post());

        return (new Success($genre))->toResponse($request);
    }
}
