@extends('layouts.app')

@section('title', 'Soundtrack Haven — Главная')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 flex flex-col gap-14">
    {{-- 1. Новые релизы альбомов --}}
    <section class="flex flex-col gap-6">
        <div class="flex justify-between items-end">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-white">Новые релизы альбомов</h2>
                <p class="text-xs md:text-sm text-gray-400 mt-1">Свежие игровые оригинальные сборники</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($latestAlbums as $album)
                <div class="bg-main-dark border border-gray-800 rounded-2xl p-4 flex flex-col hover:border-violet-500/50 transition-all group shadow-lg">
                    <div class="overflow-hidden rounded-xl mb-3 aspect-square bg-gray-900 relative">
                        <img src="{{ $album->cover_url }}" 
                             alt="{{ $album->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <h3 class="font-bold text-white text-sm truncate" title="{{ $album->title }}">
                        {{ $album->title }}
                    </h3>

                    <p class="text-xs text-gray-400 mt-1 truncate">
                        {{ $album->author?->name ?? 'Неизвестный автор' }}
                    </p>

                    <div class="mt-auto pt-3 flex items-center justify-between text-[11px] text-gray-500">
                        <span>{{ $album->release_date?->format('Y') ?? '—' }}</span>
                        <span>{{ $album->tracks->count() }} треков</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-2xl">
                    Альбомов пока нет.
                </div>
            @endforelse
        </div>
    </section>

    {{-- 2. Треки, которые стоит послушать (сетка из 3 колонок) --}}
    <section id="featured-tracks" class="flex flex-col gap-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-white">Треки, которые стоит послушать</h2>
            <p class="text-xs md:text-sm text-gray-400 mt-1">Популярные композиции из игровых миров</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($featuredTracks as $index => $track)
                <div class="bg-main-dark border border-gray-800 hover:border-violet-500/40 rounded-2xl p-3 flex items-center justify-between transition-colors group">
                    <div class="flex items-center gap-3.5 min-w-0">
                        {{-- Обложка от альбома --}}
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 shrink-0 border border-gray-700/60">
                            <img src="{{ $track->album?->cover_url ?? asset('img/default-cover.png') }}" 
                                 alt="{{ $track->title }}" 
                                 class="w-full h-full object-cover">
                        </div>

                        <div class="min-w-0">
                            <h4 class="font-semibold text-white text-sm truncate group-hover:text-violet-300 transition-colors">
                                {{ $track->title }}
                            </h4>
                            <p class="text-xs text-gray-400 truncate mt-0.5">
                                {{ $track->author?->name ?? '—' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pl-2 shrink-0">
                        <span class="text-xs font-mono text-gray-500">
                            {{ $track->duration_ms ? gmdate('i:s', (int)($track->duration_ms / 1000)) : '' }}
                        </span>

                        {{-- Кнопка добавить в плейлист (если авторизован) --}}
                        @auth
                            @if(auth()->user()->playlists->isNotEmpty())
                                <div class="relative group/menu">
                                    <button type="button" class="text-gray-400 hover:text-white p-1.5 rounded-lg hover:bg-main-light/50 transition-colors" title="В плейлист">
                                        +
                                    </button>
                                    <div class="hidden group-hover/menu:block absolute right-0 bottom-full mb-2 w-48 bg-main-dark border border-gray-700 rounded-xl shadow-2xl z-50 p-1.5">
                                        <div class="text-[10px] font-semibold text-gray-400 uppercase px-2 py-1">В плейлист:</div>
                                        @foreach(auth()->user()->playlists as $p)
                                            <form action="{{ route('playlists.tracks.add', $p) }}" method="POST">
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
                <div class="col-span-full py-10 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-2xl">
                    Треки пока не добавлены.
                </div>
            @endforelse
        </div>
    </section>

    {{-- 3. Популярные авторы --}}
    <section class="flex flex-col gap-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-white">Легендарные авторы</h2>
            <p class="text-xs md:text-sm text-gray-400 mt-1">Композиторы, создавшие звук великих игр</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @forelse($popularAuthors as $author)
                <div class="bg-main-dark border border-gray-800 rounded-2xl p-4 flex flex-col items-center text-center hover:border-violet-500/50 transition-all group">
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-900 mb-3 border-2 border-gray-700 group-hover:border-violet-400 transition-colors shadow-md">
                        <img src="{{ $author->image_url }}" 
                             alt="{{ $author->name }}" 
                             class="w-full h-full object-cover">
                    </div>

                    <h3 class="font-bold text-white text-sm truncate max-w-full">
                        {{ $author->name }}
                    </h3>

                    <p class="text-[11px] text-gray-400 mt-1">
                        {{ $author->albums_count }} альбомов · {{ $author->tracks_count }} треков
                    </p>
                </div>
            @empty
                <div class="col-span-full py-10 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-2xl">
                    Авторы пока не добавлены.
                </div>
            @endforelse
        </div>
    </section>

    {{-- 4. Публичные плейлисты сообщества --}}
    @if($publicPlaylists->isNotEmpty())
        <section class="flex flex-col gap-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($publicPlaylists as $playlist)
                    <div class="bg-main-dark border border-gray-800 rounded-2xl p-4 flex flex-col hover:border-violet-500/50 transition-all group shadow-lg">
                        <a href="{{ route('playlists.show', $playlist) }}" class="overflow-hidden rounded-xl mb-3 aspect-square bg-gray-900 block">
                            <img src="{{ $playlist->cover_url }}" 
                                 alt="{{ $playlist->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </a>

                        <h3 class="font-bold text-white text-sm truncate">
                            <a href="{{ route('playlists.show', $playlist) }}" class="hover:text-violet-300 transition-colors">
                                {{ $playlist->title }}
                            </a>
                        </h3>

                        <p class="text-xs text-gray-400 mt-1 truncate">
                            {{ $playlist->user?->name ?? 'Пользователь' }}
                        </p>

                        <div class="mt-auto pt-3 text-[11px] text-gray-500">
                            {{ $playlist->tracks_count }} треков
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection