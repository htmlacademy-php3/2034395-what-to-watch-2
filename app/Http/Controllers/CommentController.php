<?php

namespace App\Http\Controllers;

use App\Http\Responses\Fail;
use App\Http\Responses\Success;
use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use LogicException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentController extends Controller
{
    public function get(Request $request): Response
    {
        return (new Success(['id' => 1]))->toResponse($request);
    }

    public function add(Request $request): Response
    {
        return (new Success(['id' => 1]))->toResponse($request);
    }

    public function change(Request $request): Response
    {
        try {
            $data = $this->getPostData($request);

            $comment = Comment::query()->find($data['comment_id']);

            if (!$comment) {
                throw new NotFoundHttpException('Comment not found', null, Response::HTTP_NOT_FOUND);
            }

            if (Gate::allows('comment.change', $comment)) {
                $comment->update($data);

                return (new Success(null, Response::HTTP_CREATED))->toResponse();
            } else {
                return (new Fail(null, 'Action forbidden', Response::HTTP_FORBIDDEN))->toResponse();
            }
        } catch (LogicException|NotFoundHttpException $exception) {
            return (new Fail(null, $exception->getMessage(), $exception->getCode()))->toResponse();
        }
    }

    public function delete(Comment $comment): Response
    {
        if (Gate::allows('comment.delete', $comment)) {
            $comment->delete();

            return (new Success(null, Response::HTTP_CREATED))->toResponse();
        } else {
            return (new Fail(null, 'Action forbidden', Response::HTTP_FORBIDDEN))->toResponse();
        }
    }
}
