<?php

namespace App\Http\Requests\Genres;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AddGenreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('moderator.action');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
