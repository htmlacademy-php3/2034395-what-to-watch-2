<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class AddCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $type = $this->route('type');

        $types = config('app.morph_aliases');

        abort_if(!in_array($type, array_keys($types)), Response::HTTP_NOT_FOUND, 'Commentable model not found');

        return true;
    }

    public function rules(): array
    {
        return [
            'text' => [
                'required',
                'string',
                'max:400',
            ],
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:10'
            ],
            'reply_id' => [
                'integer',
                'exists:comment'
            ]
        ];
    }
}
