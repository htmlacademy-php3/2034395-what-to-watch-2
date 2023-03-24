<?php

namespace App\Http\Controllers;

use App\Http\Responses\Success;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request): Response
    {
        return (new Success(['token' => '1234']))->toResponse($request);
    }

    public function login(Request $request): Response
    {
        return (new Success(['token' => '1234']))->toResponse($request);
    }

    public function logout(): void
    {
    }
}
