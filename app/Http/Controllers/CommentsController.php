<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\AddCommentRequest;
use App\Http\Requests\Comments\ChangeCommentRequest;
use App\Http\Requests\Comments\DeleteCommentRequest;
use App\Http\Responses\Success;
use App\Models\Comment;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommentsController extends Controller
{
    public function getAll(Request $request, Film $film): Response
    {
        $comments = $film->comments()->get()->all();

        return (new Success($comments))->toResponse($request);
    }

    public function add(AddCommentRequest $request, Film $film): Response
    {
        $data = $request->post();

        if (Auth::check()) {
            $data['user_id'] = Auth::user()->id;
        }

        $comment = $film->comments()->create($data);

        return (new Success($comment,Response::HTTP_CREATED))->toResponse($request);
    }

    public function change(ChangeCommentRequest $request, Comment $comment): Response
    {
        $data = $request->post();

        $comment->update($data);

        return (new Success($comment))->toResponse($request);
    }

    public function delete(DeleteCommentRequest $request, Comment $comment): Response
    {
        $comment->delete();

        return (new Success($comment,Response::HTTP_CREATED))->toResponse($request);
    }
}
