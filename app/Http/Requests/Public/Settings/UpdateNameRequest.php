<?php

namespace App\Http\Requests\Public\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'Выберите файл изображения.',
            'avatar.image'    => 'Файл должен быть изображением.',
            'avatar.mimes'    => 'Поддерживаются форматы: JPG, PNG, WEBP.',
            'avatar.max'      => 'Размер изображения не должен превышать 3 МБ.',
        ];
    }
}
