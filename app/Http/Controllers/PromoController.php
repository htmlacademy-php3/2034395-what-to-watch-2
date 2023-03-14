<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class PromoController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        return response()->json(['promo' => []]);
    }

    public function add(Request $request): Response
    {
        return response('added');
    }
}
