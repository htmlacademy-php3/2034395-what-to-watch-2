<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DeleteCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('moderator.action');
    }

    public function rules(): array
    {
        return [];
    }
}
