<?php

namespace App\Http\Controllers;

use App\Http\Responses\Success;
use App\Models\Favorite;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FavoritesController extends Controller
{
    public function get(Request $request): Response
    {
        $favorites = Auth::user()->favorites()->get()->all();

        return (new Success($favorites))->toResponse($request);
    }

    public function add(Request $request, Film $film): Response
    {
        Favorite::query()->create(['user_id' => Auth::user()->id, 'film_id' => $film->id]);

        return (new Success($film, Response::HTTP_CREATED))->toResponse($request);
    }

    public function delete(Request $request, Film $film): Response
    {
        Favorite::query()
            ->where('user_id', '=', Auth::user()->id)
            ->where('film_id', '=', $film->id)
            ->first()
            ->delete();

        return (new Success($film, Response::HTTP_CREATED))->toResponse($request);
    }
}
