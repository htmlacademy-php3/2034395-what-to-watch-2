<?php

namespace App\Http\Controllers;

use App\Http\Responses\Fail;
use App\Http\Responses\Success;
use App\Models\Checker;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function getAll(Request $request, string $type, int $id): Response
    {
        try {
            $types = config('app.morph_aliases');

            (new Checker())->check(!in_array($type, array_keys($types)), BadRequestHttpException::class);

            $commentable = $types[$type]::query()->find($id)->first();

            (new Checker())->check(!$commentable || !$commentable->comments()->exists(), NotFoundHttpException::class);

            $comments = $commentable->comments()->get()->all();

            return (new Success(['comments' => $comments, 'total' => count($comments)]))->toResponse($request);
        } catch (BadRequestHttpException|NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function add(Request $request, string $type, int $id): Response
    {
        try {
            $types = config('app.morph_aliases');

            $data = $request->post();

            (new Checker())->check(
                !isset($data) || !in_array($type, array_keys($types)),
                BadRequestHttpException::class
            );

            $commentable = $types[$type]::query()->find($id)->first();


            (new Checker())->check(!$commentable, NotFoundHttpException::class);

            $comment = $commentable->comments()->create($data);

            return (new Success(['comment' => $comment]))->toResponse($request);
        } catch (BadRequestHttpException|NotFoundHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }

    public function change(Request $request, Comment $comment): Response
    {
        try {
            $data = $request->post();

            (new Checker())->check(!Gate::allows('comment.change', $comment), AccessDeniedHttpException::class);

            $comment->update($data);

            return (new Success(['comment' => $comment], Response::HTTP_CREATED))->toResponse($request);
        } catch (NotFoundHttpException|AccessDeniedHttpException $exception) {
            return (new Fail([], $exception->getMessage(), $exception->getCode()))->toResponse($request);
        }
    }

    public function delete(Request $request, Comment $comment): Response
    {
        try {
            (new Checker())->check(!Gate::allows('comment.delete'), AccessDeniedHttpException::class);

            $comment->delete();

            return (new Success(['comment' => $comment], Response::HTTP_CREATED))->toResponse($request);
        } catch (NotFoundHttpException|AccessDeniedHttpException $error) {
            return (new Fail([], $error->getMessage(), $error->getCode()))->toResponse($request);
        }
    }
}
