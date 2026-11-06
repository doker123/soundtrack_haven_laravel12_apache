<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BanUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user()?->hasRole("admin");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "reason" => ["required", "string", "max:500"],
            "expires_at" => ["nullable", "date", "after:now"],
        ];
    }

    public function messages(): array
    {
        return [
            "reason.required" => "Укажите причину бана.",
            "reason.max" => "Причина не должна превышать 500 символов.",
            "expires_at.date" => "Некорректная дата окончания бана.",
            "expires_at.after" => "Дата окончания должна быть в будущем.",
        ];
    }
}
