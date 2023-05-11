<?php

namespace App\Http\Controllers;

use App\Http\Requests\Films\AddFilmRequest;
use App\Http\Requests\Films\ChangeFilmRequest;
use App\Http\Responses\Success;
use App\Jobs\AddFilm;
use App\Models\Film;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilmsController extends Controller
{
    public function getAll(Request $request): Response
    {
        $films = Film::query()->get()->all();

        return (new Success(['films' => $films, 'total' => count($films)]))->toResponse($request);
    }

    public function get(Request $request, Film $film): Response
    {
        return (new Success(['film' => $film]))->toResponse($request);
    }

    public function similar(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'film name']))->toResponse($request);
    }

    public function add(AddFilmRequest $request): Response
    {
        $film = Film::query()->create($request->post());

        return (new Success(['film' => $film], Response::HTTP_CREATED))->toResponse($request);
    }

    public function change(ChangeFilmRequest $request, Film $film): Response
    {
        $film->update($request->post());

        return (new Success(['film' => $film]))->toResponse($request);
    }

    public function request(Request $request): Response
    {
        AddFilm::dispatch($request->route('imdb_id'));

        return (new Success(['status' => 'ok'], Response::HTTP_CREATED))->toResponse($request);
    }
}
