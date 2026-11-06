@extends('layouts.app')

@section('title', 'Админ: Треки')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-violet-400 font-semibold uppercase tracking-wider mb-1">
                <span>Панель управления</span>
                <span>/</span>
                <span>Треки</span>
            </div>
            <h1 class="text-3xl font-extrabold text-white">Все треки</h1>
        </div>

        <a href="{{ route('admin.tracks.create') }}"
           class="bg-[#6d5898] hover:bg-[#5825b5] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg flex items-center gap-2">
            + Загрузить трек
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Сетка-таблица треков --}}
    <div class="bg-main-dark border border-gray-800 rounded-3xl overflow-hidden shadow-xl">
        {{-- Header --}}
        <div class="hidden md:grid grid-cols-12 gap-4 items-center px-6 py-4 bg-main-light/60 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-800">
            <div class="col-span-1 text-center">#</div>
            <div class="col-span-4">Название</div>
            <div class="col-span-2">Автор</div>
            <div class="col-span-2">Альбом</div>
            <div class="col-span-1 text-center">Время</div>
            <div class="col-span-2 text-right">Действия</div>
        </div>

        {{-- Body --}}
        <div class="divide-y divide-gray-800/80">
            @forelse($tracks as $index => $track)
                <div class="grid grid-cols-2 md:grid-cols-12 gap-4 items-center px-6 py-3.5 hover:bg-main-light/30 transition-colors text-sm">
                    {{-- Позиция --}}
                    <div class="col-span-1 text-gray-500 font-mono text-center">
                        {{ $index + 1 }}
                    </div>

                    {{-- Название --}}
                    <div class="col-span-4 font-semibold text-white truncate">
                        <a href="{{ route('admin.tracks.show', $track) }}" class="hover:text-violet-300 transition-colors">
                            {{ $track->title }}
                        </a>
                    </div>

                    {{-- Автор --}}
                    <div class="col-span-2 text-gray-400 truncate">
                        {{ $track->author?->name ?? '—' }}
                    </div>

                    {{-- Альбом --}}
                    <div class="col-span-2 text-gray-400 truncate text-xs">
                        {{ $track->album?->title ?? '—' }}
                    </div>

                    {{-- Длительность --}}
                    <div class="col-span-1 text-gray-400 font-mono text-xs text-center">
                        {{ $track->duration_ms ? gmdate('i:s', (int)($track->duration_ms / 1000)) : '—' }}
                    </div>

                    {{-- Действия --}}
                    <div class="col-span-2 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.tracks.edit', $track) }}" class="text-xs text-yellow-400 hover:text-yellow-300 hover:underline">
                            Изменить
                        </a>
                        <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300 hover:underline cursor-pointer">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-500">
                    Треков пока нет.
                </div>
            @endforelse
        </div>
        {{-- Пагинация --}}
        <div class="mt-6">
            {{ $tracks->links() }}
        </div>
    </div>
</div>
@endsection
