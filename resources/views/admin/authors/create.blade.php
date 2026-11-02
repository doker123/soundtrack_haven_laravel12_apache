@extends('layouts.app')

@section('title', 'Добавить автора')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.authors.index') }}" class="text-xs text-gray-400 hover:text-white transition-colors">
            ← Вернуться к списку авторов
        </a>
        <h1 class="text-3xl font-bold text-white mt-2">Добавить автора</h1>
    </div>

    <div class="bg-main-dark border border-gray-800 p-8 rounded-3xl shadow-xl">
        {{-- ВАЖНО: enctype="multipart/form-data" обязателен для загрузки файлов --}}
        <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Изображение / Фото автора --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Фотография / Аватар</label>
                <div class="flex items-center gap-5">
                    {{-- Поле выбора файла --}}
                    <div class="flex-1">
                        <input type="file" id="image" name="image" accept="image/*"
                               class="block w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-800 file:text-gray-200 hover:file:bg-gray-700 file:transition-colors file:cursor-pointer cursor-pointer border border-gray-700 rounded-xl bg-main-light focus:outline-none focus:border-violet-500">
                        <p class="text-xs text-gray-500 mt-1">Форматы: JPG, PNG, WEBP. До 2 МБ.</p>
                        @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Имя автора --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Имя / Псевдоним автора *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-violet-500 transition-colors"
                       placeholder="Например: Mick Gordon, Akira Yamaoka, Hans Zimmer">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Биография --}}
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">Биография / Описание</label>
                <textarea id="bio" name="bio" rows="5"
                          class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-violet-500 transition-colors"
                          placeholder="Краткая биография композитора, известные проекты...">{{ old('bio') }}</textarea>
                @error('bio') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Кнопки --}}
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-800">
                <a href="{{ route('admin.authors.index') }}" class="px-5 py-2.5 text-sm text-gray-400 hover:text-white transition-colors">
                    Отмена
                </a>
                <button type="submit"
                        class="bg-[#6d5898] hover:bg-[#5825b5] text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md">
                    Создать автора
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
