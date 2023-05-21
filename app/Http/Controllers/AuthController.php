<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Responses\Success;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(UserRequest $request): Response
    {
        $params = $request->safe()->except('file');

        $user = User::query()->create($params);

        Auth::login($user);

        return (new Success($user, Response::HTTP_CREATED))->toResponse($request);
    }

    public function login(LoginRequest $request): Response
    {
        abort_if(!Auth::attempt($request->validated()), Response::HTTP_UNAUTHORIZED, trans('auth.failed'));

        return (new Success(['status' => 'ok']))->toResponse($request);
    }

    public function logout(Request $request): Response
    {
        Auth::user()->tokens()->delete();
        Auth::logout();

        return (new Success(['status' => 'ok']))->toResponse($request);
    }
}
