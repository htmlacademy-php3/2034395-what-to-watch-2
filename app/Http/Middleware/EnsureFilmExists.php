<?php

namespace App\Http\Middleware;

use App\Models\Film;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFilmExists
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $film = Film::query()->find($request->route('film'))->first();

        abort_if(!$film->exists(), Response::HTTP_NOT_FOUND, 'Film not found');

        return $next($request);
    }
}
