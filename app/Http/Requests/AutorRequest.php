<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:45'],
            'nacionalidade' => ['required', 'string', 'max:45'],
            'nascimento' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'biografia' => ['required', 'string', 'max:16000'],
        ];
    }
}
