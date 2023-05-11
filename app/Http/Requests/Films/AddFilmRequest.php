<?php

namespace App\Http\Requests\Films;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AddFilmRequest extends FormRequest
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
            'poster_image' => [
                'string',
                'max:255',
            ],
            'preview_image' => [
                'string',
                'max:255',
            ],
            'background_image' => [
                'string',
                'max:255',
            ],
            'background_color' => [
                'string',
                'max:9',
            ],
            'video_link' => [
                'string',
                'max:255',
            ],
            'preview_video_link' => [
                'string',
                'max:255',
            ],
            'description' => [
                'string',
                'max:1000',
            ],
            'director' => [
                'string',
                'max:255',
            ],
            'run_time' => [
                'integer',
            ],
            'released' => [
                'integer',
            ],
            'imdb_id' => [
                'required',
                'string',
                'unique:films',
                'regex:/tt[0-9]+/i'
            ],
            'status' => [
                'required',
                'string',
                'in:pending,on moderation,ready'
            ],
            'is_promo' => [
                'boolean'
            ],
        ];
    }
}
