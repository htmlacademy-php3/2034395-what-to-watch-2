<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        return response()->json(['user' => []]);
    }

    public function change(Request $request): Response
    {
        return response('changed');
    }
}
