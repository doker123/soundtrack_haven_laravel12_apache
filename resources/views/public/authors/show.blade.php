@extends('layouts.app')
@section('title', $author->name . ' — Soundtrack Haven')
@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 flex flex-col gap-12">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8 bg-main-dark border border-gray-800 rounded-3xl p-6 md:p-8">
        <div class="w-40 h-40 md:w-52 md:h-52 rounded-full overflow-hidden bg-gray-900 shrink-0 border-4 border-gray-800 shadow-2xl">
            <img src="{{ $author->image_url }}"
                 alt="{{ $author->name }}"
                 class="w-full h-full object-cover">
        </div>
        <div class="flex flex-col gap-3 items-center md:items-start text-center md:text-left flex-1 min-w-0">
            <span class="text-xs uppercase tracking-widest text-violet-400 font-bold">Композитор / Автор</span>
            <h1 class="text-3xl md:text-5xl font-black text-white truncate max-w-full">
                {{ $author->name }}
            </h1>
            <p class="text-sm text-gray-400 flex items-center gap-3">
                <span>{{ $author->albums->count() }} {{ trans_choice('альбом|альбома|альбомов', $author->albums->count()) }}</span>
                <span>•</span>
                <span>{{ $author->tracks->count() }} {{ trans_choice('трек|трека|треков', $author->tracks->count()) }}</span>
            </p>
            @if($author->bio)
                <p class="text-sm text-gray-300 mt-2 line-clamp-3 md:line-clamp-none max-w-3xl leading-relaxed">
                    {{ $author->bio }}
                </p>
            @endif
            @if($author->tracks->isNotEmpty())
                <div class="mt-3">
                    <button id="play-all-author-tracks"
                            type="button"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-violet-600 hover:bg-violet-700 text-white font-semibold rounded-xl shadow-lg transition">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <span>Слушать композитора</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <section class="flex flex-col gap-6">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Треки автора</h2>
            <p class="text-xs md:text-sm text-gray-400 mt-0.5">Все композиции в каталоге</p>
        </div>
        <div class="flex flex-col gap-2">
            @forelse($author->tracks as $index => $track)
                <div class="flex items-center justify-between p-3 rounded-xl bg-main-dark/50 hover:bg-main-light/30 border border-gray-800/80 hover:border-violet-500/40 transition group cursor-pointer"
                     data-track-id="{{ $track->id }}"
                     data-track-url="{{ route('tracks.stream', $track) }}"
                     data-track-title="{{ $track->title }}"
                     data-track-author="{{ $author->name }}"
                     data-track-cover="{{ $track->album?->cover_url ?? asset('images/default-cover.svg') }}"
                     data-track-duration="{{ $track->duration_ms ? (int)($track->duration_ms / 1000) : 0 }}">
                    <div class="flex items-center gap-4 min-w-0">
                        <span class="text-gray-500 w-6 text-center font-mono text-sm shrink-0">{{ $index + 1 }}</span>
                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-900 shrink-0 border border-gray-700/60">
                            <img src="{{ $track->album?->cover_url ?? asset('images/default-cover.svg') }}"
                                 alt="{{ $track->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-semibold text-white text-sm truncate group-hover:text-violet-300 transition">
                                {{ $track->title }}
                            </h4>
                            @if($track->album)
                                <a href="{{ route('public.albums.show', $track->album) }}"
                                   onclick="event.stopPropagation()"
                                   class="text-[11px] text-gray-400 hover:text-white truncate block hover:underline">
                                    {{ $track->album->title }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="text-xs font-mono text-gray-500">
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
                                <div class="relative group/menu" onclick="event.stopPropagation()">
                                    <button type="button" class="text-gray-400 hover:text-white p-1.5 rounded-lg hover:bg-main-light transition" title="В плейлист">
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
                <div class="p-8 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-2xl">
                    У автора пока нет загруженных треков.
                </div>
            @endforelse
        </div>
    </section>
    <section class="flex flex-col gap-6">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Альбомы</h2>
            <p class="text-xs md:text-sm text-gray-400 mt-0.5">Дискография композитора</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($author->albums as $album)
                <div class="bg-main-dark border border-gray-800 rounded-2xl p-4 flex flex-col hover:border-violet-500/50 transition-all group shadow-lg">
                    <a href="{{ route('public.albums.show', $album) }}" class="overflow-hidden rounded-xl mb-3 aspect-square bg-gray-900 block">
                        <img src="{{ $album->cover_url }}"
                             alt="{{ $album->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </a>
                    <h3 class="font-bold text-white text-sm truncate">
                        <a href="{{ route('public.albums.show', $album) }}" class="hover:text-violet-300 transition-colors">
                            {{ $album->title }}
                        </a>
                    </h3>
                    <div class="mt-auto pt-3 flex items-center justify-between text-[11px] text-gray-500">
                        <span>{{ $album->release_date?->format('Y') ?? '—' }}</span>
                        <span>{{ $album->tracks->count() }} треков</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-2xl">
                    Альбомов пока нет.
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
