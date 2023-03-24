<?php

namespace App\Http\Controllers;

use App\Http\Responses\Success;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
    public function getAll(Request $request): Response
    {
        return (new Success(['id' => 1, 'genre' => 'genre name']))->toResponse($request);
    }

    public function change(Request $request): Response
    {
        return (new Success(['id' => 1, 'genre' => 'genre name']))->toResponse($request);
    }
}
