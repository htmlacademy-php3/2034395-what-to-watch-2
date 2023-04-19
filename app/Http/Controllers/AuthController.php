<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Responses\Success;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(UserRequest $request): Response
    {
        $params = $request->safe()->except('file');
        $user = User::create($params);
        $token = $user->createToken('auth-token');

        return (new Success([
            'user' => $user,
            'token' => $token->plainTextToken,
        ]))->toResponse($request);
    }

    public function login(LoginRequest $request): Response
    {
        if (!Auth::attempt($request->validated())) {
            abort(401, trans('auth.failed'));
        }

        $token = Auth::user()->createToken('auth-token');

        return (new Success(['token' => $token->plainTextToken]))->toResponse($request);
    }

    public function logout(): void
    {
        Auth::user()->tokens()->delete();
    }
}
