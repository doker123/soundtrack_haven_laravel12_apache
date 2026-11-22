@extends('layouts.app')

@section('title', $album->title . ' — Soundtrack Haven')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 flex flex-col gap-8">
    {{-- Шапка альбома --}}
    <div class="flex flex-col md:flex-row items-center md:items-end gap-6 bg-main-dark border border-gray-800 rounded-3xl p-6">
        <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-48 h-48 rounded-2xl object-cover shadow-2xl">
        <div class="flex flex-col gap-2">
            <span class="text-xs uppercase tracking-wider text-violet-400 font-semibold">Альбом</span>
            <h1 class="text-3xl md:text-5xl font-black text-white">{{ $album->title }}</h1>
            <p class="text-gray-400 text-sm">
                Автор: <span class="text-white font-medium">{{ $album->author?->name ?? 'Неизвестен' }}</span>
                - {{ $album->release_date?->format('Y') }}
                - {{ $album->tracks->count() }} треков
            </p>
            <button id="play-album-btn"
                    type="button"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white font-bold rounded-xl shadow-lg transition duration-200 w-3xs">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
                <span>Слушать альбом</span>
            </button>
        </div>
    </div>

    {{-- Список треков --}}
    <div class="flex flex-col gap-2">
        @forelse($album->tracks as $index => $track)
            <div class="bg-main-dark border border-gray-800 hover:border-violet-500/40 rounded-2xl p-3 flex items-center justify-between transition-colors group cursor-pointer"
                 data-track-id="{{ $track->id }}"
                 data-track-url="{{ route('tracks.stream', $track) }}"
                 data-track-title="{{ $track->title }}"
                 data-track-author="{{ $album->author?->name }}"
                 data-track-cover="{{ $album->cover_url }}"
                 data-track-duration="{{ $track->duration_ms ? (int)($track->duration_ms / 1000) : 0 }}">

                <div class="flex items-center gap-4 min-w-0">
                    <span class="text-gray-500 w-6 text-center font-mono text-sm">{{ $index + 1 }}</span>
                    <span class="font-semibold text-white group-hover:text-violet-400 transition truncate">{{ $track->title }}</span>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 font-mono">
                        {{ $track->duration_ms ? gmdate('i:s', (int)($track->duration_ms / 1000)) : '' }}
                    </span>
                    {{-- Добавить в плейлист --}}
                    @auth
                        {{-- Кнопка с плюсом --}}
                    @endauth
                </div>
            </div>
        @empty
            <div class="text-gray-500 text-center py-8">В этом альбоме пока нет треков</div>
        @endforelse
    </div>
</div>
@endsection
