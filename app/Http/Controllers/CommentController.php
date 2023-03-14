<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function get(int $filmId): array
    {
        return [];
    }

    public function add(int $filmId, string $text, int $rating): void
    {

    }

    public function change(int $id, string $text, int $rating): void
    {

    }

    public function delete(int $id): void
    {

    }
}
