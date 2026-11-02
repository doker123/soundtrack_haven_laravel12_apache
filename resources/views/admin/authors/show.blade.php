@extends('layouts.app')

@section('title', $author->name)

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.authors.index') }}" class="text-sm text-gray-400 hover:text-white transition-colors">
            ← Назад к авторам
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.authors.edit', $author) }}" class="text-xs bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500/20 px-4 py-2 rounded-xl border border-yellow-500/30 font-medium">
                Редактировать
            </a>
            <form action="{{ route('admin.authors.destroy', $author) }}" method="POST"">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs bg-red-500/10 text-red-400 hover:bg-red-500/20 px-4 py-2 rounded-xl border border-red-500/30 font-medium cursor-pointer">
                    Удалить
                </button>
            </form>
        </div>
    </div>

    {{-- Профиль автора --}}
    <div class="flex flex-col sm:flex-row gap-8 items-center sm:items-start bg-main-dark border border-gray-800 p-8 rounded-3xl mb-10 shadow-xl">
        <img src="{{ $author->image_url }}" alt="{{ $author->name }}"
            class="w-32 h-32 rounded-full object-cover border-4 border-violet-900 bg-gray-900 shrink-0 shadow-lg">

        <div class="flex-1 text-center sm:text-left">
            <h1 class="text-3xl font-extrabold text-white mb-2">{{ $author->name }}</h1>
            <div class="flex items-center justify-center sm:justify-start gap-4 text-xs text-gray-400 mb-4">
                <span>Альбомов: {{ $author->albums->count() }}</span>
                <span>•</span>
                <span>Треков: {{ $author->tracks->count() }}</span>
            </div>
            @if($author->bio)
                <p class="text-sm text-gray-300 leading-relaxed max-w-2xl whitespace-pre-line wrap-break-word">{{ $author->bio }}</p>
            @endif
        </div>
    </div>

    {{-- Сетка альбомов автора на CSS Grid --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Альбомы автора</h2>
        <a href="{{ route('admin.albums.create') }}?author_id={{ $author->id }}" class="text-xs text-violet-400 hover:underline">
            + Создать альбом для этого автора
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @forelse($author->albums as $album)
            <div class="bg-main-dark border border-gray-800 rounded-2xl p-4 flex flex-col hover:border-violet-500/40 transition-all group">
                <a href="{{ route('admin.albums.show', $album) }}" class="aspect-square rounded-xl overflow-hidden mb-3 block bg-gray-900">
                    <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </a>
                <h3 class="font-bold text-white text-sm truncate">
                    <a href="{{ route('admin.albums.show', $album) }}" class="hover:text-violet-300 transition-colors">
                        {{ $album->title }}
                    </a>
                </h3>
                <span class="text-xs text-gray-500 mt-1">
                    {{ $album->release_date?->format('Y') ?? '—' }}
                </span>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-3xl">
                У этого автора пока нет созданных альбомов.
            </div>
        @endforelse
    </div>
</div>
@endsection