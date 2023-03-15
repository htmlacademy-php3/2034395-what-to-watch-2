<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        return response()->json(['token' => '1234']);
    }

    public function login(Request $request): JsonResponse
    {
        return response()->json(['token' => '1234']);
    }

    public function logout(): Response
    {
        return response('logged out');
    }
}
