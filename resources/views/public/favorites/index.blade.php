@extends('layouts.app')

@section('title', 'Soundtrack Haven — Избранное')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 flex flex-col gap-8">

    
    <section>
        <h1 class="text-2xl md:text-3xl font-extrabold text-white">
            Избранные треки
        </h1>
        <p class="text-xs md:text-sm text-gray-400 mt-1">
            Ваша личная коллекция любимой музыки
        </p>
    </section>

    
    <section class="flex flex-col gap-5">

        @if($tracks->isNotEmpty())

            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-white">
                    Мои треки
                </h2>

                <span class="text-xs text-gray-400">
                    Всего: {{ $tracks->total() }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-4">

                @foreach($tracks as $track)

                    <div class="bg-main-dark border border-gray-800
                                hover:border-violet-500/40 rounded-2xl p-3
                                flex items-center justify-between
                                transition-colors group"

                         data-track-id="{{ $track->id }}"
                         data-track-url="{{ route('tracks.stream', $track) }}"
                         data-track-title="{{ $track->title }}"
                         data-track-author="{{ $track->author?->name ?? 'Неизвестный автор' }}"
                         data-track-cover="{{ $track->album?->cover_url ?? asset('images/default-cover.svg') }}"
                         data-track-duration="{{ $track->duration_ms ? (int)($track->duration_ms / 1000) : 0 }}">

                        
                        <div class="flex items-center gap-3.5 min-w-0">

                            <div class="w-12 h-12 rounded-xl overflow-hidden
                                        bg-gray-900 shrink-0 border border-gray-700/60">

                                <img src="{{ $track->album?->cover_url ?? asset('images/default-cover.svg') }}"
                                     alt="{{ $track->title }}"
                                     class="w-full h-full object-cover">
                            </div>

                            <div class="min-w-0">
                                <h3 class="font-semibold text-white text-sm
                                           truncate group-hover:text-violet-300
                                           transition-colors">

                                    {{ $track->title }}

                                </h3>

                                <p class="text-xs text-gray-400 truncate mt-0.5">
                                    {{ $track->author?->name ?? 'Неизвестный автор' }}
                                </p>
                            </div>

                        </div>

                        
                        <div class="flex items-center gap-2 pl-2 shrink-0">

                            <span class="text-xs font-mono text-gray-500">
                                {{ $track->duration_ms ? gmdate('i:s', (int)($track->duration_ms / 1000)) : '' }}
                            </span>

                            
                            <form action="{{ route('public.favorites.toggle', $track) }}"
                                  method="POST">

                                @csrf

                                <button type="submit"
                                        class="text-red-400 hover:text-red-300
                                               p-1.5 rounded-lg
                                               hover:bg-red-500/10
                                               transition-colors"
                                        title="Убрать из избранного">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="20"
                                         height="20"
                                         viewBox="0 0 24 24"
                                         fill="currentColor"
                                         stroke="currentColor"
                                         stroke-width="1.5"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">

                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>

                                    </svg>

                                </button>

                            </form>

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

                        </div>

                    </div>

                @endforeach

            </div>

            
            <div class="mt-4">
                {{ $tracks->links() }}
            </div>

        @else

            
            <div class="py-16 text-center bg-main-dark
                        border border-gray-800 rounded-2xl">

                <div class="flex justify-center mb-4">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="56"
                         height="56"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.5"
                         class="text-gray-600">

                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>

                    </svg>

                </div>

                <h3 class="text-xl font-bold text-white mb-2">
                    Здесь пока пусто
                </h3>

                <p class="text-sm text-gray-400 mb-6">
                    Добавляйте понравившиеся треки в избранное,
                    чтобы они всегда были под рукой.
                </p>

                <a href="{{ route('home') }}"
                   class="inline-block px-6 py-3 bg-violet-600
                          hover:bg-violet-500 text-white text-sm
                          font-semibold rounded-xl transition-colors">

                    Перейти к музыке

                </a>

            </div>

        @endif

    </section>

</div>
@endsection
