<?php

namespace App\Http\Controllers;

use App\Http\Responses\Success;
use App\Models\Film;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PromoController extends Controller
{
    public function get(Request $request): Response
    {
        $promo = Film::query()->where('is_promo', '=', true)->get()->first();

        abort_if(!$promo, Response::HTTP_NOT_FOUND, 'Promo not found');

        return (new Success($promo))->toResponse($request);
    }

    public function add(Request $request, Film $film): Response
    {
        $promo = Film::query()->where('is_promo', '=', true)->get()->first();

        if ($promo) {
            $promo->update(['is_promo' => false]);
        }

        $film->update(['is_promo' => true]);

        return (new Success($film))->toResponse($request);
    }
}
