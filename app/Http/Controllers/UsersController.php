<?php

namespace App\Http\Controllers;

use App\Http\Responses\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function get(Request $request): Response
    {
        return (new Success(Auth::user()))->toResponse($request);
    }

    public function change(Request $request): Response
    {
        Auth::user()->update($request->post());

        return (new Success(Auth::user()))->toResponse($request);
    }
}
