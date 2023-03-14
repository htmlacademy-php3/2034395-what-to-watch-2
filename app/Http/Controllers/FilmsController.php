<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FilmsController extends Controller
{
    public function getAll(Request $request): JsonResponse
    {
        return response()->json(['films' => []]);
    }

    public function get(Film $film): JsonResponse
    {
        return response()->json(['film' => []]);
    }

    public function similar(Request $request): JsonResponse
    {
        return response()->json(['films' => []]);
    }

    public function add(Request $request): Response
    {
        return response('added');
    }

    public function change(Request $request): Response
    {
        return response('changed');
    }
}
