@extends('layouts.app')

@section('title', 'Редактировать: ' . $album->title)

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.albums.index') }}" class="text-xs text-gray-400 hover:text-white transition-colors">
            ← Вернуться к списку альбомов
        </a>
        <h1 class="text-3xl font-bold text-white mt-2">Редактировать альбом</h1>
    </div>

    <div class="bg-main-dark border border-gray-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('admin.albums.update', $album) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Название --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Название альбома *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $album->title) }}" required
                       class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500 transition-colors">
                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Сетка: Автор и Статус --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="author_id" class="block text-sm font-medium text-gray-300 mb-2">Автор *</label>
                    <select id="author_id" name="author_id" required 
                            class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500">
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" @selected(old('author_id', $album->author_id) == $author->id)>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="status_id" class="block text-sm font-medium text-gray-300 mb-2">Статус *</label>
                    <select id="status_id" name="status_id" required 
                            class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500">
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" @selected(old('status_id', $album->status_id) == $status->id)>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Сетка: Дата выхода и Позиция --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="release_date" class="block text-sm font-medium text-gray-300 mb-2">Дата выхода</label>
                    <input type="date" id="release_date" name="release_date" 
                           value="{{ old('release_date', $album->release_date?->format('Y-m-d')) }}"
                           class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500">
                    @error('release_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="position" class="block text-sm font-medium text-gray-300 mb-2">Позиция</label>
                    <input type="number" id="position" name="position" value="{{ old('position', $album->position) }}" min="0"
                           class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500">
                    @error('position') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Текущая обложка и загрузка новой --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Обложка</label>
                <div class="flex items-center gap-5 p-4 bg-main-light/50 border border-gray-700 rounded-2xl mb-3">
                    <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-20 h-20 object-cover rounded-xl border border-gray-600 bg-gray-900">
                    <div class="text-xs text-gray-400">
                        <p class="font-medium text-white mb-1">Текущая обложка</p>
                        <p>Загрузите новый файл ниже, если хотите заменить текущую обложку.</p>
                    </div>
                </div>

                <input type="file" id="cover_path" name="cover_path" accept="image/png, image/jpeg, image/webp"
                       class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-violet-600 file:text-white hover:file:bg-violet-700 cursor-pointer border border-gray-700 rounded-xl bg-main-light p-1">
                @error('cover_path') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Описание --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Описание</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500">{{ old('description', $album->description) }}</textarea>
                @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Кнопки --}}
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-800">
                <a href="{{ route('admin.albums.index') }}" class="px-5 py-2.5 text-sm text-gray-400 hover:text-white transition-colors">
                    Отмена
                </a>
                <button type="submit" 
                        class="bg-[#6d5898] hover:bg-[#5825b5] text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md">
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</div>
@endsection