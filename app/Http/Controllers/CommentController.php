<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\AddCommentRequest;
use App\Http\Requests\Comments\ChangeCommentRequest;
use App\Http\Requests\Comments\DeleteCommentRequest;
use App\Http\Responses\Success;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function getAll(Request $request, string $type, int $id): Response
    {
        $types = config('app.morph_aliases');

        abort_if(!in_array($type, array_keys($types)), Response::HTTP_NOT_FOUND, 'Commentable model not found');

        $commentable = $types[$type]::query()->find($id)->first();

        $comments = $commentable->comments()->get()->all();

        return (new Success(['comments' => $comments, 'total' => count($comments)]))->toResponse($request);
    }

    public function add(AddCommentRequest $request, string $type, int $id): Response
    {
        $types = config('app.morph_aliases');
        $commentable = $types[$type]::query()->find($id)->first();

        $data = $request->post();

        if (Auth::check()) {
            $data['user_id'] = Auth::user()->id;
        }

        $comment = $commentable->comments()->create($data);

        return (new Success(['comment' => $comment], Response::HTTP_CREATED))->toResponse($request);
    }

    public function change(ChangeCommentRequest $request, Comment $comment): Response
    {
        $data = $request->post();

        $comment->update($data);

        return (new Success(['comment' => $comment]))->toResponse($request);
    }

    public function delete(DeleteCommentRequest $request, Comment $comment): Response
    {
        $comment->delete();

        return (new Success(['comment' => $comment], Response::HTTP_CREATED))->toResponse($request);
    }
}
