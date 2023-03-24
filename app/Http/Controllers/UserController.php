<?php

namespace App\Http\Controllers;

use App\Http\Responses\Success;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function get(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'user name']))->toResponse($request);
    }

    public function change(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'user name']))->toResponse($request);
    }
}
