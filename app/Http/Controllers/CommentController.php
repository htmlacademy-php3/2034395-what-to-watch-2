<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        return response()->json(['comments' => []]);
    }

    public function add(Request $request): Response
    {
        return response('added');
    }

    public function change(Request $request): Response
    {
        return response('changed');
    }

    public function delete(Request $request): Response
    {
        return response('deleted');
    }
}
