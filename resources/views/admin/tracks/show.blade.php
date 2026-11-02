@extends('layouts.app')

@section('title', $track->title)

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.tracks.index') }}" class="text-sm text-gray-400 hover:text-white transition-colors">
            ← Назад к трекам
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tracks.edit', $track) }}" class="text-xs bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500/20 px-4 py-2 rounded-xl border border-yellow-500/30 font-medium">
                Редактировать
            </a>
            <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST" onsubmit="return confirm('Удалить этот трек?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs bg-red-500/10 text-red-400 hover:bg-red-500/20 px-4 py-2 rounded-xl border border-red-500/30 font-medium cursor-pointer">
                    Удалить
                </button>
            </form>
        </div>
    </div>

    <div class="bg-main-dark border border-gray-800 p-8 rounded-3xl shadow-xl">
        <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start mb-6">
            {{-- Обложка альбома или дефолтная --}}
            <img src="{{ $track->album?->cover_url ?? asset('img/default-cover.png') }}" 
                 alt="{{ $track->title }}" 
                 class="w-44 h-44 rounded-2xl object-cover shadow-xl border border-gray-700 bg-gray-900 shrink-0">

            <div class="flex-1 text-center sm:text-left">
                <span class="text-xs font-semibold px-2.5 py-1 bg-violet-950 text-violet-300 rounded-full border border-violet-800">
                    {{ $track->status?->name ?? 'published' }}
                </span>

                <h1 class="text-3xl font-extrabold text-white mt-3">{{ $track->title }}</h1>
                <p class="text-gray-300 mt-1">Автор: <span class="text-violet-400 font-medium">{{ $track->author?->name ?? '—' }}</span></p>

                @if($track->album)
                    <p class="text-sm text-gray-400 mt-1">
                        Альбом: <a href="{{ route('admin.albums.show', $track->album) }}" class="hover:underline text-gray-200">{{ $track->album->title }}</a>
                    </p>
                @endif

                <div class="flex items-center justify-center sm:justify-start gap-4 text-xs text-gray-400 mt-4">
                    @if($track->duration_ms)
                        <span>Длительность: {{ gmdate('i:s', (int)($track->duration_ms / 1000)) }}</span>
                    @endif
                    @if($track->file_size)
                        <span>•</span>
                        <span>Размер: {{ round($track->file_size / 1024 / 1024, 2) }} МБ</span>
                    @endif
                    @if($track->mime_type)
                        <span>•</span>
                        <span>Тип: {{ $track->mime_type }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection