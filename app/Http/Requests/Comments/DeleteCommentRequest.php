<?php

namespace App\Http\Requests\Comments;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DeleteCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $comment = Comment::query()->find($this->route('comment'))->first();

        return Gate::allows('comment.action', $comment);
    }

    public function rules(): array
    {
        return [];
    }
}
