<?php

namespace App\Http\Requests\Genres;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ChangeGenreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('moderator.action');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'max:255',
            ],
        ];
    }
}
