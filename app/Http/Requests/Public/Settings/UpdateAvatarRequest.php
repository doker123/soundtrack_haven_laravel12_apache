<?php
namespace App\Http\Requests\Public\Settings;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:50'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Введите имя / никнейм.',
            'name.string'   => 'Имя должно быть строкой.',
            'name.min'      => 'Имя должно содержать минимум 2 символа.',
            'name.max'      => 'Имя не должно превышать 50 символов.',
        ];
    }
}
