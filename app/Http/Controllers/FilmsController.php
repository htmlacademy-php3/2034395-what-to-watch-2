<?php

namespace App\Http\Controllers;

use App\Http\Requests\Films\AddFilmRequest;
use App\Http\Requests\Films\ChangeFilmRequest;
use App\Http\Responses\Success;
use App\Jobs\AddFilm;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FilmsController extends Controller
{
    public function add(AddFilmRequest $request): Response
    {
        AddFilm::dispatch($request->post('imdb_id'));

        return (new Success(['status' => 'ok'], Response::HTTP_CREATED))->toResponse($request);
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

    public function similar(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'film name']))->toResponse($request);
    }
}
