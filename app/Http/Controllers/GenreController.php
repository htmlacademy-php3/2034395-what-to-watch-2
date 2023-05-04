<?php

namespace App\Http\Controllers;

use App\Http\Responses\Fail;
use App\Http\Responses\Success;
use App\Models\Checker;
use App\Models\Genre;
use Illuminate\Http\Request;
use LogicException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenreController extends Controller
{
    public function getAll(Request $request): Response
    {
        try {
            $genres = Genre::query()->get()->all();

            (new Checker())->check(!$genres, NotFoundHttpException::class);

            return (new Success(['genres' => $genres, 'total' => count($genres)]))->toResponse($request);
        } catch (NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function add(Request $request): Response
    {
        try {
            $name = $request->post('name');

            (new Checker())->check(!isset($name), BadRequestHttpException::class);

            $genre = Genre::query()->create(['name' => $name]);

            return (new Success(['genre' => $genre]))->toResponse($request);
        } catch (BadRequestHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function change(Request $request): Response
    {
        try {
            $id = $request->post('id');
            $name = $request->post('name');

            (new Checker())->check(!isset($id, $name), BadRequestHttpException::class);

            $genre = Genre::query()->find($id);

            (new Checker())->check(!$genre, NotFoundHttpException::class);

            (new Checker())->check(!$genre->update(['name' => $name]), LogicException::class);

            return (new Success(['genre' => $genre]))->toResponse($request);
        } catch (BadRequestHttpException|NotFoundHttpException|LogicException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }
}
