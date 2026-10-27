<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrackRequest extends FormRequest
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
            "author_id" => ["required", "integer", "exists:authors,id"],
            "album_id" => ["required", "integer", "exists:album,id"],
            "status_id" => ["required", "integer", "exists:statuses,id"],
            "cover" => ["required", "file", 'mimes:jpg,png,jpeg', "max:2080"],
            "release_date" => ["nullable", "date"],
            "description" => ["nullable", "string"],
            "position" => ["nullable", "integer", "min:0", "max:255"],

            'audio' => ['required', 'file', 'mimes:mp3,wav,flac,ogg', 'max:51200'],
        ];
    }
    public function messages(): array
    {
        return [
            "title.required" => "Введите название альбома",
            "author_id.required" => "Выберите автора",
            "author_id.exists" => "Такого автора нет",
            "status_id.required" => "Выберите статус",
            "status_id.exists" => "Такого статуса нет",
            "release_date.date" => "Дата указывается в формате ГГГГ-ММ-ДД",
            "position.max" => "Позиция не более 255",
        ];
    }
}
