<?php

namespace App\Http\Requests\Public\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Укажите адрес электронной почты.',
            'email.email'    => 'Введите корректный адрес электронной почты.',
            'email.unique'   => 'Этот email уже занят другим пользователем.',
            'email.max'      => 'Email не должен превышать 255 символов.',
        ];
    }
}
