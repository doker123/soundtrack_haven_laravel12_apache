<?php

namespace App\Http\Requests\Public;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePlaylistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:255"],
            "description" => ["nullable", "string", "max:1000"],
            "cover" => [
                "nullable",
                "image",
                "mimes:jpeg,png,jpg,webp",
                "max:3072",
            ],
            "is_public" => ["nullable", "boolean"],
        ];
    }
    public function messages(): array
    {
        return [
            "title.required" => "Название обязательно.",
            "title.string" => "Должно быть строкой.",
            "title.max" => "Максимум 255 символов.",
            "description.max" => "Максимум 1000 символов",
            "cover.max" => "Максимум размер фото 3мб",
            "cover.mimes"=> "Расшиерние фото должно быть: jpeg,png,jpg,webp",
        ];
    }
}
