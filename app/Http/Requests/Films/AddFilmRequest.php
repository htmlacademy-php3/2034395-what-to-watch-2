<?php

namespace App\Http\Requests\Films;

use Illuminate\Foundation\Http\FormRequest;

class AddFilmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'imdb_id' => [
                'required',
                'string',
                'unique:films',
                'regex:/tt[0-9]+/i'
            ],
        ];
    }
}
