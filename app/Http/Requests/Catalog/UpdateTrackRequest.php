<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackRequest extends FormRequest
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
            "title" => ["required", "string", "max:255"],
            "author_id" => ["nullable", "integer", "exists:authors,id"],
            "album_id" => ["nullable", "integer", "exists:albums,id"],
            "status_id" => ["required", "integer", "exists:statuses,id"],
            "duration_ms" => ["nullable", "integer", "min:0"],
            "audio" => [
                "nullable",
                "file",
                "mimes:mp3,wav,flac,ogg",
                "max:51200",
            ],
        ];
    }
    public function messages(): array
    {
        return [
            "audio.file" => "Загрузите корректный файл",
            "audio.mimes" => "Поддерживаются форматы: mp3, wav, flac, ogg",
            "audio.max" => "Файл больше 50 МБ",
            "title.required" => "Введите название трека",
            "status_id.required" => "Выберите статус",
        ];
    }
}
