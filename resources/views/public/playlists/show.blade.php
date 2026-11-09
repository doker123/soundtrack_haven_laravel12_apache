@extends('layouts.app')

@section('title', $playlist->title)

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <a href="{{ route('playlists.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white mb-6">
        ← К моим плейлистам
    </a>

    {{-- Шапка плейлиста --}}
    <div class="flex flex-col md:flex-row gap-8 items-start bg-main-dark border border-gray-800 p-8 rounded-3xl mb-8 shadow-xl">
        <img src="{{ $playlist->cover_url }}" alt="{{ $playlist->title }}" class="w-52 h-52 object-cover rounded-2xl shadow-xl shrink-0 border border-gray-700 bg-gray-900">
        <div class="flex-1">
            <span class="inline-block px-3 py-1 bg-violet-950 text-violet-300 text-xs font-semibold rounded-full border border-violet-800 mb-3">
                {{ $playlist->is_public ? 'Публичный плейлист' : 'Приватный плейлист' }}
            </span>
            <h1 class="text-3xl font-extrabold text-white mb-2">{{ $playlist->title }}</h1>
            <p class="text-gray-400 text-sm mb-4">Создатель: {{ $playlist->user->name }} · {{ $playlist->tracks->count() }} треков</p>

            @if($playlist->description)
                <p class="text-sm text-gray-300 leading-relaxed mb-6">{{ $playlist->description }}</p>
            @endif

            @can('update', $playlist)
                <div class="flex items-center gap-3">
                    <a href="{{ route('playlists.edit', $playlist) }}" class="text-xs bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500/20 px-4 py-2 rounded-xl border border-yellow-500/30">
                        Редактировать
                    </a>
                    <form action="{{ route('playlists.destroy', $playlist) }}" method="POST" onsubmit="return confirm('Удалить этот плейлист?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs bg-red-500/10 text-red-400 hover:bg-red-500/20 px-4 py-2 rounded-xl border border-red-500/30 cursor-pointer">
                            Удалить
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </div>

    {{-- Список треков в плейлисте --}}
    <div class="bg-main-dark border border-gray-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="divide-y divide-gray-800/80">
            @forelse($playlist->tracks as $index => $track)
                <div class="grid grid-cols-12 gap-4 items-center px-6 py-3.5 hover:bg-main-light/30 transition-colors text-sm">
                    <div class="col-span-1 text-gray-500 font-mono text-center">{{ $index + 1 }}</div>
                    <div class="col-span-5 font-semibold text-white truncate">
                        {{ $track->title }}
                    </div>
                    <div class="col-span-3 text-gray-400 truncate">{{ $track->author?->name ?? '—' }}</div>
                    <div class="col-span-2 text-gray-500 text-xs font-mono text-center">
                        {{ $track->duration_ms ? gmdate('i:s', (int)($track->duration_ms / 1000)) : '—' }}
                    </div>

                    @can('update', $playlist)
                        <div class="col-span-1 text-right">
                            <form action="{{ route('playlists.tracks.remove', [$playlist, $track]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-400 hover:text-red-300 p-1 cursor-pointer" title="Убрать из плейлиста">
                                    ✕
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">В этом плейлисте пока нет добавленных треков.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
