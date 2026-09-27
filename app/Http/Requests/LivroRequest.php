<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LivroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:45', Rule::unique('livro', 'isbn')->ignore($this->route('livro'))],
            'anopublicacao' => ['required', 'integer', 'min:1', 'max:9999'],
            'descricao' => ['required', 'string', 'max:255'],
            'paginas' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'idautor' => ['required', 'integer', 'exists:autor,idautor'],
            'idcategoria' => ['required', 'integer', 'exists:categoria,idcategoria'],
        ];
    }
}
