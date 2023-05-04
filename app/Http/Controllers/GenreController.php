<?php

namespace App\Http\Controllers;

use App\Http\Responses\Fail;
use App\Http\Responses\Success;
use App\Models\Genre;
use Illuminate\Http\Request;
use LogicException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenreController extends Controller
{
    public function getAll(Request $request): Response
    {
        try {
            $genres = Genre::query()->get()->all();

            throw_if(
                !$genres,
                new NotFoundHttpException('Not Found', null, Response::HTTP_NOT_FOUND),
            );

            return (new Success($genres))->toResponse($request);
        } catch (NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function add(Request $request): Response
    {
        try {
            $name = $request->post('name');

            throw_if(
                !isset($name),
                new BadRequestException('Bad Request', Response::HTTP_BAD_REQUEST),
            );

            $genre = Genre::query()->create(['name' => $name]);

            return (new Success($genre))->toResponse($request);
        } catch (BadRequestException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function change(Request $request): Response
    {
        try {
            $id = $request->post('id');
            $name = $request->post('name');

            throw_if(
                !isset($id, $name),
                new BadRequestException('Bad Request', Response::HTTP_BAD_REQUEST),
            );

            $genre = Genre::query()->find($id);

            throw_if(
                !$genre,
                new NotFoundHttpException('Not Found', null, Response::HTTP_NOT_FOUND),
            );

            throw_if(
                !$genre->update(['name' => $name]),
                new LogicException('Genre not updated', Response::HTTP_CONFLICT),
            );

            return (new Success($genre))->toResponse($request);
        } catch (BadRequestException|NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }
}
