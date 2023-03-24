<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        return response()->json(['favorite' => []]);
    }

    public function add(Request $request): Response
    {
        return response('added');
    }

    public function delete(Request $request): Response
    {
        return response('deleted');
    }
}
