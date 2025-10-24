<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'content' => ['required','string'],
            'category_id' => ['required','integer','exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'content.required' => 'El contenido es obligatorio.',
            'category_id.required' => 'Selecciona una categoría.',
        ];
    }
}
