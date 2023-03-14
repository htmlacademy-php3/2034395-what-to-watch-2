<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    public function getAll(Request $request): JsonResponse
    {
        return response()->json(['genres' => []]);
    }

    public function change(Request $request): Response
    {
        return response('changed');
    }
}
