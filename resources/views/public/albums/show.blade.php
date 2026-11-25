@extends('layouts.app')
@section('title', $album->title . ' — Soundtrack Haven')
@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 flex flex-col gap-8">
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
                    @auth
                        <form action="{{ route('public.favorites.toggle', $track) }}"
                              method="POST">
                            @csrf
                            <button type="submit"
                                    class="p-1.5 rounded-lg transition-colors
                                    {{ auth()->user()->favoriteTracks()->where('track_id', $track->id)->exists()
                                        ? 'text-red-500 hover:text-red-400'
                                        : 'text-gray-400 hover:text-red-400' }}"
                                    title="Добавить в избранное">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="20"
                                     height="20"
                                     viewBox="0 0 24 24"
                                     fill="{{ auth()->user()->favoriteTracks()->where('track_id', $track->id)->exists() ? 'currentColor' : 'none' }}"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </form>
                    @endauth
                    @auth
                        @if(auth()->user()->playlists->isNotEmpty())
                            <div class="relative group/menu">
                                <button type="button" class="text-gray-400 hover:text-white p-1.5 rounded-lg hover:bg-main-light/50 transition-colors" title="В плейлист">
                                    +
                                </button>
                                <div class="hidden group-hover/menu:block absolute right-0 bottom-full mb-2 w-48 bg-main-dark border border-gray-700 rounded-xl shadow-2xl z-50 p-1.5">
                                    <div class="text-[10px] font-semibold text-gray-400 uppercase px-2 py-1">В плейлист:</div>
                                    @foreach(auth()->user()->playlists as $p)
                                        <form action="{{ route('public.playlists.tracks.add', $p) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="track_id" value="{{ $track->id }}">
                                            <button type="submit" class="w-full text-left px-2 py-1.5 text-xs text-gray-300 hover:text-white hover:bg-violet-600/30 rounded-lg truncate block">
                                                {{ $p->title }}
                                            </button>
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div class="text-gray-500 text-center py-8">В этом альбоме пока нет треков</div>
        @endforelse
    </div>
</div>
@endsection
