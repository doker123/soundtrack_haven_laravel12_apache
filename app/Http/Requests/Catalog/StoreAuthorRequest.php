<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user()?->hasRole('admin'); 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=> ['requared', 'string', 'max:255'],
            'bio'=> ['nullable', 'string', 'max:1000']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите имя автора',
            'name.max'      => 'Имя не длиннее 255 символов',
            'bio.string'    => 'Биография должнабыть строкой',
            'bio.max'       => 'Максимум 1000 символов'
        ];
    }
}
