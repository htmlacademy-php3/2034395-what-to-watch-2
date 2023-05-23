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
    public function add(AddFilmRequest $request): Response
    {
        $film = Film::query()->create($request->post());

        AddFilm::dispatch($film);

        return (new Success($film, Response::HTTP_CREATED))->toResponse($request);
    }

    public function change(ChangeFilmRequest $request, Film $film): Response
    {
        $film->update($request->post());

        return (new Success($film, Response::HTTP_CREATED))->toResponse($request);
    }

    public function getAll(Request $request): Response
    {
        $genre = $request->route('genre');
        $status = $request->route('status');
        $orderBy = $request->route('order_by');
        $orderTo = $request->route('order_to');

        $query = Film::query();

        if ($genre) {
            $query = $query->where('genre', '=', $genre);
        }

        if ($status) {
            $query = $query->where('status', '=', $status);
        }

        if ($orderBy) {
            $query = $query->orderBy($orderBy, $orderTo);
        }

        $films = $query->with('actors')->with('genres')->paginate(15);

        return (new Success($films->items()))->toResponseWithPagination($request, $films);
    }

    public function get(Request $request, Film $film): Response
    {
        $filmWithRelations = Film::query()
            ->find($film->id)
            ->with('genres')
            ->with('actors')
            ->first();

        return (new Success($filmWithRelations))->toResponse($request);
    }

    public function similar(Request $request, Film $film): Response
    {
        $genre = $film->genres()->inRandomOrder()->get()->first();

        $similar = $genre->films()->where('films.id', '!=', $film->id)->limit(4)->get()->all();

        return (new Success($similar))->toResponse($request);
    }
}
