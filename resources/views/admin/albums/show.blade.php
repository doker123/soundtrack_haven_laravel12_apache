@extends('layouts.app')

@section('title', $album->title)

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    {{-- Навигация и действия --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.albums.index') }}" class="text-sm text-gray-400 hover:text-white transition-colors">
            ← Назад к списку альбомов
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.albums.edit', $album) }}" class="text-xs bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500/20 px-4 py-2 rounded-xl border border-yellow-500/30 font-medium transition-colors">
                Редактировать
            </a>
            <form action="{{ route('admin.albums.destroy', $album) }}" method="POST" onsubmit="return confirm('Удалить альбом «{{ $album->title }}»?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs bg-red-500/10 text-red-400 hover:bg-red-500/20 px-4 py-2 rounded-xl border border-red-500/30 font-medium transition-colors cursor-pointer">
                    Удалить
                </button>
            </form>
        </div>
    </div>

    {{-- Карточка альбома --}}
    <div class="flex flex-col md:flex-row gap-8 items-start bg-main-dark border border-gray-800 p-8 rounded-3xl mb-8 shadow-xl">
        <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-56 h-56 object-cover rounded-2xl shadow-xl shrink-0 border border-gray-700 bg-gray-900">
        <div class="flex-1">
            <span class="inline-block px-3 py-1 bg-violet-950 text-violet-300 text-xs font-semibold rounded-full border border-violet-800 mb-3">
                {{ $album->status?->name ?? 'Альбом' }}
            </span>
            <h1 class="text-3xl font-extrabold text-white mb-2">{{ $album->title }}</h1>
            <p class="text-gray-300 text-base mb-4">
                Автор: <span class="text-violet-400 font-medium">{{ $album->author?->name ?? 'Неизвестен' }}</span>
            </p>

            <div class="flex items-center gap-4 text-xs text-gray-400 mb-4">
                <span>Дата выхода: {{ $album->release_date?->format('d.m.Y') ?? 'Не указана' }}</span>
                <span>•</span>
                <span>Треков: {{ $album->tracks->count() }}</span>
            </div>

            @if($album->description)
                <p class="text-sm text-gray-400 leading-relaxed max-w-2xl">{{ $album->description }}</p>
            @endif
        </div>
    </div>

    {{-- Список треков альбома на CSS Grid --}}
    <div class="bg-main-dark border border-gray-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="flex justify-between items-center p-6 border-b border-gray-800">
            <h2 class="text-xl font-bold text-white">Треки альбома</h2>
            <a href="{{ route('admin.tracks.create') }}?album_id={{ $album->id }}" class="text-xs text-violet-400 hover:text-violet-300 font-medium">
                + Добавить трек в этот альбом
            </a>
        </div>

        {{-- Заголовок Grid-таблицы треков --}}
        <div class="hidden md:grid grid-cols-12 gap-4 items-center px-6 py-3.5 bg-main-light/40 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-800">
            <div class="col-span-1 text-center">#</div>
            <div class="col-span-7">Название трека</div>
            <div class="col-span-2 text-center">Длительность</div>
            <div class="col-span-2 text-right">Действия</div>
        </div>

        {{-- Строки треков --}}
        <div class="divide-y divide-gray-800/80">
            @forelse($album->tracks as $index => $track)
                <div class="grid grid-cols-2 md:grid-cols-12 gap-4 items-center px-6 py-3 hover:bg-main-light/30 transition-colors text-sm">
                    <div class="col-span-1 text-gray-500 font-mono text-center">
                        {{ $index + 1 }}
                    </div>

                    <div class="col-span-7 font-medium text-white truncate">
                        <a href="{{ route('admin.tracks.show', $track) }}" class="hover:text-violet-300 transition-colors">
                            {{ $track->title }}
                        </a>
                    </div>

                    <div class="col-span-2 text-gray-400 font-mono text-xs text-center">
                        {{ $track->duration_ms ? gmdate('i:s', (int)($track->duration_ms / 1000)) : '—' }}
                    </div>

                    <div class="col-span-2 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.tracks.edit', $track) }}" class="text-xs text-yellow-400 hover:underline">
                            Изменить
                        </a>
                        <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST" onsubmit="return confirm('Удалить трек?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:underline cursor-pointer">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    В этом альбоме пока нет треков.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection