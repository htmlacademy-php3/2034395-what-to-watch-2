<?php

namespace App\Http\Controllers;

use App\Http\Responses\Success;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FavoritesController extends Controller
{
    public function get(Request $request): Response
    {
        $favorites = $request->user()->favorites()->get()->all();

        return (new Success($favorites))->toResponse($request);
    }

    public function add(Request $request, Film $film): Response
    {
        $favorite = $request->user()->favorites()->create();

        $favorite->film()->associate($film);

        $favorite->save();

        return (new Success($film, Response::HTTP_CREATED))->toResponse($request);
    }

    public function delete(Request $request, Film $film): Response
    {
        $request->user()->favorites()->where('film_id', '=', $film->id)->first()->delete();

        return (new Success($film, Response::HTTP_CREATED))->toResponse($request);
    }
}
