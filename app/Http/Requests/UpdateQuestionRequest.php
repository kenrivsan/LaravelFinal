<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Usa la policy: sólo el autor puede actualizar
        return $this->user()?->can('update', $this->route('question')) ?? false;
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
