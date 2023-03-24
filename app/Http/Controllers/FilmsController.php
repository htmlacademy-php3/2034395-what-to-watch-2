<?php

namespace App\Http\Controllers;

use App\Http\Responses\Success;
use App\Models\Film;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilmsController extends Controller
{
    public function getAll(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'film name']))->toResponse($request);
    }

    public function get(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'film name']))->toResponse($request);
    }

    public function similar(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'film name']))->toResponse($request);
    }

    public function add(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'film name']))->toResponse($request);
    }

    public function change(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'film name']))->toResponse($request);
    }
}
