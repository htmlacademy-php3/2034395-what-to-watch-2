<?php

namespace App\Http\Controllers;

use App\Http\Responses\Fail;
use App\Http\Responses\Success;
use App\Models\Checker;
use App\Models\Film;
use Illuminate\Http\Request;
use LogicException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FilmsController extends Controller
{
    public function getAll(Request $request): Response
    {
        try {
            $films = Film::query()->get()->all();

            (new Checker())->check(!$films, NotFoundHttpException::class);

            return (new Success(['films' => $films, 'total' => count($films)]))->toResponse($request);
        } catch (NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function get(Film $film): Response
    {
        return (new Success(['film' => $film]))->toResponse();
    }

    public function similar(Request $request): Response
    {
        return (new Success(['id' => 1, 'name' => 'film name']))->toResponse($request);
    }

    public function add(Request $request): Response
    {
        try {
            $data = $request->post();

            (new Checker())->check(
                !isset($data['name'], $data['imdb_id'], $data['status'], $data['is_promo']),
                BadRequestHttpException::class
            );

            $film = Film::query()->create($data);

            return (new Success(['film' => $film]))->toResponse($request);
        } catch (BadRequestHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function change(Request $request): Response
    {
        try {
            $data = $request->post();

            (new Checker())->check(!isset($data['id']), BadRequestHttpException::class);

            $film = Film::query()->find($data['id']);

            (new Checker())->check(!$film, NotFoundHttpException::class);

            (new Checker())->check(!$film->update([$data]), LogicException::class);

            return (new Success(['film' => $film]))->toResponse($request);
        } catch (BadRequestHttpException|NotFoundHttpException|LogicException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }
}
