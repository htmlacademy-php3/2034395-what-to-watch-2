<?php

namespace App\Http\Controllers;

use App\Http\Responses\Fail;
use App\Http\Responses\Success;
use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use LogicException;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentController extends Controller
{
    public function getAll(Request $request, string $type, int $id): Response
    {
        try {
            $types = config('app.morph_aliases');

            throw_if(
                !in_array($type, array_keys($types)),
                new BadRequestException('Bad Request', Response::HTTP_BAD_REQUEST),
            );

            $commentable = $types[$type]::query()->find($id)->first();

            throw_if(
                !$commentable || !$commentable->comments(),
                new NotFoundHttpException('Not Found', null, Response::HTTP_NOT_FOUND),
            );

            return (new Success($commentable->comments()->get()->all()))->toResponse($request);
        } catch (NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function add(Request $request, string $type, int $id): Response
    {
        try {
            $types = config('app.morph_aliases');

            $data = $request->post();

            throw_if(
                !isset($data) || !in_array($type, array_keys($types)),
                new BadRequestException('Bad Request', Response::HTTP_BAD_REQUEST),
            );

            $commentable = $types[$type]::query()->find($id)->first();

            throw_if(
                !$commentable,
                new NotFoundHttpException('Not Found', null, Response::HTTP_NOT_FOUND),
            );

            $comment = $commentable->comments()->create($data);

            return (new Success($comment))->toResponse($request);
        } catch (BadRequestException|NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function change(Request $request, Comment $comment): Response
    {
        try {
            $data = $request->post();

            throw_if(
                !Gate::allows('comment.change', $comment),
                new AccessDeniedException('Forbidden', Response::HTTP_FORBIDDEN),
            );

            $comment->update($data);

            return (new Success($comment, Response::HTTP_CREATED))->toResponse($request);
        } catch (BadRequestException|NotFoundHttpException|AccessDeniedException $exception) {
            return (new Fail([], $exception->getMessage(), $exception->getCode()))->toResponse($request);
        }
    }

    public function delete(Request $request, Comment $comment): Response
    {
        try {
            throw_if(
                !Gate::allows('comment.delete'),
                new AccessDeniedException('Forbidden', Response::HTTP_FORBIDDEN),
            );

            $comment->delete();

            return (new Success([], Response::HTTP_CREATED))->toResponse($request);
        } catch (BadRequestException|NotFoundHttpException|AccessDeniedException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }
}
