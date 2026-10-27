<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateAlbumRequest extends FormRequest
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
                'author_id'    => 'sometimes|required|integer|exists:authors,id',
                'status_id'    => 'sometimes|required|integer|exists:statuses,id',
                'title'        => 'sometimes|required|string|max:255',
                'cover_path'   => 'nullable|string|max:255',
                'release_date' => 'nullable|date',
                'description'  => 'nullable|string',
                'position'     => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
                'author_id.exists'  => 'Выбранный автор не существует в базе данных.',
                'status_id.exists'  => 'Выбранный статус недействителен.',
                'title.required'    => 'Название альбома не может быть пустым.',
                'title.max'         => 'Название не должно превышать 255 символов.',
                'release_date.date' => 'Введите корректную дату релиза.',
        ];
    }
}
