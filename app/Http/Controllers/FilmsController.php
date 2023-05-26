<?php

namespace App\Http\Controllers;

use App\Http\Filters\FilmsFilter;
use App\Http\Requests\Films\AddFilmRequest;
use App\Http\Requests\Films\ChangeFilmRequest;
use App\Http\Responses\Success;
use App\Jobs\AddFilm;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FilmsController extends Controller
{
    public function add(AddFilmRequest $request): Response
    {
        $film = Film::query()->create($request->validated());

        AddFilm::dispatch($film);

        return (new Success($film, Response::HTTP_CREATED))->toResponse($request);
    }

    public function change(ChangeFilmRequest $request, Film $film): Response
    {
        $film->update($request->validated());

        return (new Success($film, Response::HTTP_CREATED))->toResponse($request);
    }

    public function getAll(Request $request): Response
    {
        $orderBy = $request->query('order_by', 'id');
        $orderTo = $request->query('order_to', 'desc');

        $films = Film::filter(new FilmsFilter($request))
            ->with(['actors', 'genres'])
            ->orderBy($orderBy, $orderTo)
            ->paginate(15);

        return (new Success($films->items()))->toResponseWithPagination($request, $films);
    }

    public function get(Request $request, Film $film): Response
    {
        return (new Success($film->with(['genres', 'actors'])->find($film)))->toResponse($request);
    }

    public function similar(Request $request, Film $film): Response
    {
        $genre = $film->genres()->inRandomOrder()->first();

        $similar = $genre->films()->where('films.id', '!=', $film->id)->limit(4)->get()->all();

        return (new Success($similar))->toResponse($request);
    }
}
