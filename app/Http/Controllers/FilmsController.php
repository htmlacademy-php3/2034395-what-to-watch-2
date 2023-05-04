<?php

namespace App\Http\Controllers;

use App\Http\Responses\Fail;
use App\Http\Responses\Success;
use App\Models\Film;
use Illuminate\Http\Request;
use LogicException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FilmsController extends Controller
{
    public function getAll(Request $request): Response
    {
        try {
            $films = Film::query()->get()->all();

            throw_if(
                !$films,
                new NotFoundHttpException('Not Found', null, Response::HTTP_NOT_FOUND),
            );

            return (new Success($films))->toResponse($request);
        } catch (NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function get(Film $film): Response
    {
        return (new Success($film))->toResponse();
    }

    public function similar(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'film name']))->toResponse($request);
    }

    public function add(Request $request): Response
    {
        try {
            $data = $request->post();

            throw_if(
                !isset($data['name'], $data['imdb_id'], $data['status'], $data['is_promo']),
                new BadRequestException('Bad Request', Response::HTTP_BAD_REQUEST),
            );

            $film = Film::query()->create($data);

            return (new Success($film))->toResponse($request);
        } catch (BadRequestException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function change(Request $request): Response
    {
        try {
            $data = $request->post();

            throw_if(
                !isset($data['id']),
                new BadRequestException('Bad Request', Response::HTTP_BAD_REQUEST),
            );

            $film = Film::query()->find($data['id']);

            throw_if(
                !$film,
                new NotFoundHttpException('Not Found', null, Response::HTTP_NOT_FOUND),
            );

            throw_if(
                !$film->update([$data]),
                new LogicException('Genre not updated', Response::HTTP_CONFLICT),
            );

            return (new Success($film))->toResponse($request);
        } catch (BadRequestException|NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }
}
