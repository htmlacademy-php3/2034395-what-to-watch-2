<?php

namespace App\Http\Controllers;

use App\Http\Responses\Success;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function get(Request $request): Response
    {
        return (new Success(['id' => 1]))->toResponse($request);
    }

    public function add(Request $request): Response
    {
        return (new Success(['id' => 1]))->toResponse($request);
    }

    public function change(Request $request): Response
    {
        return (new Success(['id' => 1]))->toResponse($request);
    }

    public function delete(Request $request): Response
    {
        return (new Success(['id' => 1]))->toResponse($request);
    }
}
