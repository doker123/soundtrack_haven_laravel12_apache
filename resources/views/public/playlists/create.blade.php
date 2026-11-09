@extends('layouts.app')

@section('title', 'Создать плейлист')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10">

    {{-- Навигация назад --}}
    <div class="mb-6">
        <a href="{{ route('playlists.index') }}"
           class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-white transition-colors">
            ← Назад к моим плейлистам
        </a>
        <h1 class="text-3xl font-extrabold text-white mt-2">Новый плейлист</h1>
    </div>

    {{-- Карточка формы --}}
    <div class="bg-main-dark border border-gray-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('playlists.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Название плейлиста --}}
            <div>
                <label for="title" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Название *
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
                       required
                       placeholder="Например: Любимые саундтреки из киберпанка"
                       class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-violet-500 transition-colors">
                @error('title')
                    <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Описание --}}
            <div>
                <label for="description" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Описание
                </label>
                <textarea id="description"
                          name="description"
                          rows="3"
                          placeholder="Небольшое описание подборки..."
                          class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-violet-500 transition-colors">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Обложка --}}
            <div>
                <label for="cover" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Обложка плейлиста
                </label>
                <input type="file"
                       id="cover"
                       name="cover"
                       accept="image/png, image/jpeg, image/webp"
                       class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-violet-600 file:text-white hover:file:bg-violet-700 cursor-pointer border border-gray-700 rounded-xl bg-main-light/40 p-1">
                <p class="text-[11px] text-gray-500 mt-1">Форматы: JPG, PNG, WEBP (до 3 МБ).</p>
                @error('cover')
                    <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Чекбокс видимости (Публичный / Приватный) --}}
            <div class="pt-2">
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox"
                           name="is_public"
                           value="1"
                           @checked(old('is_public', true))
                           class="w-5 h-5 rounded-lg border-gray-700 bg-main-light/40 text-violet-600 focus:ring-violet-500 focus:ring-offset-0 cursor-pointer">
                    <div>
                        <span class="text-sm font-medium text-white block">Публичный плейлист</span>
                        <span class="text-xs text-gray-400 block">Другие пользователи смогут находить и слушать этот плейлист</span>
                    </div>
                </label>
                @error('is_public')
                    <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Кнопки действий --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800">
                <a href="{{ route('playlists.index') }}"
                   class="px-5 py-2.5 text-sm text-gray-400 hover:text-white transition-colors">
                    Отмена
                </a>
                <button type="submit"
                        class="bg-[#6d5898] hover:bg-[#5825b5] text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md cursor-pointer">
                    Создать плейлист
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
