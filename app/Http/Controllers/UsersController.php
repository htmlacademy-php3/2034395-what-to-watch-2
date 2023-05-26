<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Responses\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function get(Request $request): Response
    {
        return (new Success($request->user()))->toResponse($request);
    }

    public function change(UserRequest $request): Response
    {
        $params = $request->safe()->except('file');

        $params['password'] = Hash::make($params['password']);

        $request->user()->update($params);

        return (new Success($request->user()))->toResponse($request);
    }
}
