<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use App\Models\Film;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCommentExists
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $comment = Comment::query()->find($request->route('comment'))->first();

        abort_if(!$comment->exists(), Response::HTTP_NOT_FOUND, 'Comment not found');

        return $next($request);
    }
}
