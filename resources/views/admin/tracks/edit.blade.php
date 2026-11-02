@extends('layouts.app')

@section('title', 'Редактировать трек: ' . $track->title)

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.tracks.index') }}" class="text-xs text-gray-400 hover:text-white transition-colors">
            ← Назад к списку треков
        </a>
        <h1 class="text-3xl font-bold text-white mt-2">Редактировать трек</h1>
    </div>

    <div class="bg-main-dark border border-gray-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('admin.tracks.update', $track) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Название --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Название трека *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $track->title) }}" required
                       class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500 transition-colors">
                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Сетка: Автор и Альбом --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="author_id" class="block text-sm font-medium text-gray-300 mb-2">Автор *</label>
                    <select id="author_id" name="author_id" required 
                            class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500">
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" @selected(old('author_id', $track->author_id) == $author->id)>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="album_id" class="block text-sm font-medium text-gray-300 mb-2">Альбом</label>
                    <select id="album_id" name="album_id" 
                            class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500">
                        <option value="">Без альбома (сингл)</option>
                        @foreach($albums as $album)
                            <option value="{{ $album->id }}" @selected(old('album_id', $track->album_id) == $album->id)>
                                {{ $album->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('album_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Статус --}}
            <div>
                <label for="status_id" class="block text-sm font-medium text-gray-300 mb-2">Статус *</label>
                <select id="status_id" name="status_id" required 
                        class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500">
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" @selected(old('status_id', $track->status_id) == $status->id)>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
                @error('status_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Замена аудиофайла --}}
            <div>
                <label for="audio" class="block text-sm font-medium text-gray-300 mb-2">Заменить аудиофайл</label>
                
                @if($track->storage_key)
                    <div class="flex items-center gap-3 p-3 bg-main-light/50 border border-gray-700 rounded-xl mb-3 text-xs text-gray-400">
                        <span>🎵 Текущий файл сохранен</span>
                        <span>•</span>
                        <span>Длительность: {{ $track->duration_ms ? gmdate('i:s', (int)($track->duration_ms / 1000)) : '—' }}</span>
                    </div>
                @endif

                <input type="file" id="audio" name="audio" accept="audio/*"
                       class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-violet-600 file:text-white hover:file:bg-violet-700 cursor-pointer border border-gray-700 rounded-xl bg-main-light p-1">
                <p class="text-xs text-gray-500 mt-1">Оставьте пустым, если не хотите перезаписывать текущий файл.</p>
                @error('audio') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Кнопки --}}
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-800">
                <a href="{{ route('admin.tracks.index') }}" class="px-5 py-2.5 text-sm text-gray-400 hover:text-white transition-colors">
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