<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Responses\Success;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(UserRequest $request): Response
    {
        $params = $request->safe()->except('file');

        $params['password'] = Hash::make($params['password']);

        $user = User::query()->create($params);

        $accessToken = $user->createToken('access_token');

        return (new Success(
            [
                'user' => $user,
                'access_token' => $accessToken->plainTextToken,
            ],
            Response::HTTP_CREATED,
        ))->toResponse($request);
    }

    public function login(LoginRequest $request): Response
    {
        $params = $request->validated();

        $user = User::query()->where('email', '=', $params['email'])->get()->first();

        abort_if(!Hash::check($params['password'], $user->password), Response::HTTP_UNAUTHORIZED, 'Wrong password');

        $token = $user->createToken('access_token');

        return (new Success(['user' => $user, 'token' => $token->plainTextToken]))->toResponse($request);
    }

    public function logout(Request $request): Response
    {
        $request->user()->tokens()->delete();

        return (new Success(['status' => 'ok']))->toResponse($request);
    }
}
