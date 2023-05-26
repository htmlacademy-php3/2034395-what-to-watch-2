<?php

namespace App\Http\Requests\Comments;

use App\Models\Film;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class AddCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
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
