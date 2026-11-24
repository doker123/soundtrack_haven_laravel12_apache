@extends('layouts.app')

@section('title', 'Поиск по каталогу — Soundtrack Haven')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 flex flex-col gap-8">

    {{-- Поисковая форма --}}
    <div class="flex flex-col gap-4">
        <h1 class="text-3xl font-extrabold text-white">Поиск</h1>
        <form action="{{ route('search') }}" method="GET" class="relative max-w-2xl">
            @if($type !== 'all')
                <input type="hidden" name="type" value="{{ $type }}">
            @endif
            <input type="text"
                   name="q"
                   value="{{ $query }}"
                   placeholder="Название трека, альбома, автор или плейлист..."
                   class="w-full bg-main-dark border border-gray-800 focus:border-violet-500 rounded-2xl py-3.5 pl-12 pr-28 text-white placeholder-gray-500 text-sm outline-none transition-all shadow-inner">
            <svg class="w-5 h-5 text-gray-500 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <button type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-violet-600 hover:bg-violet-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-colors">
                Найти
            </button>
        </form>

        @if($query !== '')
            <p class="text-xs text-gray-400">
                Результаты поиска по запросу «<span class="text-white font-medium">{{ $query }}</span>»: найдено {{ $counts['total'] }}
            </p>
        @endif
    </div>

    @if($query !== '' && mb_strlen($query) >= 2)
        {{-- Вкладки фильтрации --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-gray-800 text-sm font-medium">
            <a href="{{ route('search', ['q' => $query, 'type' => 'all']) }}"
               class="px-4 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $type === 'all' ? 'bg-violet-600 text-white shadow-md' : 'bg-main-dark text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>Все</span>
                <span class="text-xs px-1.5 py-0.5 rounded-full {{ $type === 'all' ? 'bg-violet-800 text-violet-100' : 'bg-gray-800 text-gray-400' }}">
                    {{ $counts['total'] }}
                </span>
            </a>

            <a href="{{ route('search', ['q' => $query, 'type' => 'tracks']) }}"
               class="px-4 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $type === 'tracks' ? 'bg-violet-600 text-white shadow-md' : 'bg-main-dark text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>Треки</span>
                <span class="text-xs px-1.5 py-0.5 rounded-full {{ $type === 'tracks' ? 'bg-violet-800 text-violet-100' : 'bg-gray-800 text-gray-400' }}">
                    {{ $counts['tracks'] }}
                </span>
            </a>

            <a href="{{ route('search', ['q' => $query, 'type' => 'albums']) }}"
               class="px-4 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $type === 'albums' ? 'bg-violet-600 text-white shadow-md' : 'bg-main-dark text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>Альбомы</span>
                <span class="text-xs px-1.5 py-0.5 rounded-full {{ $type === 'albums' ? 'bg-violet-800 text-violet-100' : 'bg-gray-800 text-gray-400' }}">
                    {{ $counts['albums'] }}
                </span>
            </a>

            <a href="{{ route('search', ['q' => $query, 'type' => 'authors']) }}"
               class="px-4 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $type === 'authors' ? 'bg-violet-600 text-white shadow-md' : 'bg-main-dark text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>Авторы</span>
                <span class="text-xs px-1.5 py-0.5 rounded-full {{ $type === 'authors' ? 'bg-violet-800 text-violet-100' : 'bg-gray-800 text-gray-400' }}">
                    {{ $counts['authors'] }}
                </span>
            </a>

            <a href="{{ route('search', ['q' => $query, 'type' => 'playlists']) }}"
               class="px-4 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $type === 'playlists' ? 'bg-violet-600 text-white shadow-md' : 'bg-main-dark text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>Плейлисты</span>
                <span class="text-xs px-1.5 py-0.5 rounded-full {{ $type === 'playlists' ? 'bg-violet-800 text-violet-100' : 'bg-gray-800 text-gray-400' }}">
                    {{ $counts['playlists'] }}
                </span>
            </a>
        </div>
    @endif

    @if($query === '' || mb_strlen($query) < 2)
        {{-- Подсказка при пустом запросе --}}
        <div class="py-16 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-3xl flex flex-col items-center">
            <div class="w-16 h-16 rounded-2xl bg-gray-900 border border-gray-800 flex items-center justify-center text-gray-400 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <p class="text-lg font-semibold text-gray-400">Введите от 2 символов для поиска</p>
            <p class="text-xs text-gray-600 mt-1">Ищите музыку, авторов, саундтреки к играм и плейлисты</p>
        </div>
    @elseif($counts['total'] === 0)
        {{-- Ничего не найдено --}}
        <div class="py-16 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-3xl flex flex-col items-center">
            <div class="w-16 h-16 rounded-2xl bg-gray-900 border border-gray-800 flex items-center justify-center text-gray-400 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-lg font-semibold text-gray-400">Ничего не найдено</p>
            <p class="text-xs text-gray-600 mt-1">Попробуйте изменить формулировку запроса или поискать другое имя</p>
        </div>
    @else

        {{-- 1. Секция: Треки --}}
        @if(($type === 'all' || $type === 'tracks') && $tracks->isNotEmpty())
            <section class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <span>Треки</span>
                        <span class="text-xs text-gray-500 font-normal">({{ $counts['tracks'] }})</span>
                    </h2>
                    @if($type === 'all' && $counts['tracks'] > $tracks->count())
                        <a href="{{ route('search', ['q' => $query, 'type' => 'tracks']) }}"
                           class="text-xs text-violet-400 hover:text-violet-300 font-semibold transition-colors">
                            Показать все треки ({{ $counts['tracks'] }}) →
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($tracks as $track)
                        <div class="bg-main-dark border border-gray-800 hover:border-violet-500/40 rounded-2xl p-3 flex items-center justify-between transition-colors group cursor-pointer"
                             data-track-id="{{ $track->id }}"
                             data-track-url="{{ route('tracks.stream', $track) }}"
                             data-track-title="{{ $track->title }}"
                             data-track-author="{{ $track->author?->name ?? 'Неизвестный автор' }}"
                             data-track-cover="{{ $track->album?->cover_url ?? asset('images/default-cover.svg') }}"
                             data-track-duration="{{ $track->duration_ms ? (int)($track->duration_ms / 1000) : 0 }}">
                            
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 shrink-0 border border-gray-700/60">
                                    <img src="{{ $track->album?->cover_url ?? asset('images/default-cover.svg') }}"
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
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($type === 'tracks' && method_exists($tracks, 'hasPages') && $tracks->hasPages())
                    <div class="mt-4">
                        {{ $tracks->links() }}
                    </div>
                @endif
            </section>
        @endif

        {{-- 2. Секция: Альбомы --}}
        @if(($type === 'all' || $type === 'albums') && $albums->isNotEmpty())
            <section class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <span>Альбомы</span>
                        <span class="text-xs text-gray-500 font-normal">({{ $counts['albums'] }})</span>
                    </h2>
                    @if($type === 'all' && $counts['albums'] > $albums->count())
                        <a href="{{ route('search', ['q' => $query, 'type' => 'albums']) }}"
                           class="text-xs text-violet-400 hover:text-violet-300 font-semibold transition-colors">
                            Показать все альбомы ({{ $counts['albums'] }}) →
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach($albums as $album)
                        <a href="{{ route('public.albums.show', $album) }}">
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
                                    <span>{{ $album->tracks_count }} треков</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($type === 'albums' && method_exists($albums, 'hasPages') && $albums->hasPages())
                    <div class="mt-4">
                        {{ $albums->links() }}
                    </div>
                @endif
            </section>
        @endif

        {{-- 3. Секция: Авторы --}}
        @if(($type === 'all' || $type === 'authors') && $authors->isNotEmpty())
            <section class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <span>Авторы</span>
                        <span class="text-xs text-gray-500 font-normal">({{ $counts['authors'] }})</span>
                    </h2>
                    @if($type === 'all' && $counts['authors'] > $authors->count())
                        <a href="{{ route('search', ['q' => $query, 'type' => 'authors']) }}"
                           class="text-xs text-violet-400 hover:text-violet-300 font-semibold transition-colors">
                            Показать всех авторов ({{ $counts['authors'] }}) →
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
                    @foreach($authors as $author)
                        <a href="{{ route('public.authors.show', $author) }}">
                            <div class="bg-main-dark border border-gray-800 rounded-2xl p-4 flex flex-col items-center text-center hover:border-violet-500/50 transition-all group">
                                <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-900 mb-3 border-2 border-gray-700 group-hover:border-violet-400 transition-colors shadow-md">
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
                        </a>
                    @endforeach
                </div>

                @if($type === 'authors' && method_exists($authors, 'hasPages') && $authors->hasPages())
                    <div class="mt-4">
                        {{ $authors->links() }}
                    </div>
                @endif
            </section>
        @endif

        {{-- 4. Секция: Плейлисты --}}
        @if(($type === 'all' || $type === 'playlists') && $playlists->isNotEmpty())
            <section class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <span>Плейлисты</span>
                        <span class="text-xs text-gray-500 font-normal">({{ $counts['playlists'] }})</span>
                    </h2>
                    @if($type === 'all' && $counts['playlists'] > $playlists->count())
                        <a href="{{ route('search', ['q' => $query, 'type' => 'playlists']) }}"
                           class="text-xs text-violet-400 hover:text-violet-300 font-semibold transition-colors">
                            Показать все плейлисты ({{ $counts['playlists'] }}) →
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach($playlists as $playlist)
                        <a href="{{ route('public.playlists.show', $playlist) }}">
                            <div class="bg-main-dark border border-gray-800 rounded-2xl p-4 flex flex-col hover:border-violet-500/50 transition-all group shadow-lg">
                                <div class="overflow-hidden rounded-xl mb-3 aspect-square bg-gray-900 relative">
                                    <img src="{{ $playlist->cover_url }}"
                                         alt="{{ $playlist->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </div>
                                <h3 class="font-bold text-white text-sm truncate" title="{{ $playlist->title }}">
                                    {{ $playlist->title }}
                                </h3>
                                <p class="text-xs text-gray-400 mt-1 truncate">
                                    {{ $playlist->user?->name ?? 'Пользователь' }}
                                </p>
                                <div class="mt-auto pt-3 flex items-center justify-between text-[11px] text-gray-500">
                                    <span>{{ $playlist->tracks_count }} треков</span>
                                    <span>{{ $playlist->is_public ? 'Публичный' : 'Личный' }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($type === 'playlists' && method_exists($playlists, 'hasPages') && $playlists->hasPages())
                    <div class="mt-4">
                        {{ $playlists->links() }}
                    </div>
                @endif
            </section>
        @endif

    @endif

</div>
@endsection
