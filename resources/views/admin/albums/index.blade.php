@extends('layouts.app')

@section('title', 'Админ: Альбомы')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    {{-- Шапка страницы --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-violet-400 font-semibold uppercase tracking-wider mb-1">
                <span>Панель управления</span>
                <span>/</span>
                <span>Альбомы</span>
            </div>
            <h1 class="text-3xl font-extrabold text-white">Управление альбомами</h1>
        </div>

        <a href="{{ route('admin.albums.create') }}"
           class="bg-[#6d5898] hover:bg-[#5825b5] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg flex items-center gap-2">
            + Добавить альбом
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Таблица на CSS Grid --}}
    <div class="bg-main-dark border border-gray-800 rounded-3xl overflow-hidden shadow-xl">
        {{-- Заголовок таблицы (Header) --}}
        <div class="hidden md:grid grid-cols-12 gap-4 items-center px-6 py-4 bg-main-light/60 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-800">
            <div class="col-span-1">Обложка</div>
            <div class="col-span-3">Название</div>
            <div class="col-span-2">Автор</div>
            <div class="col-span-2">Статус</div>
            <div class="col-span-2">Дата выхода</div>
            <div class="col-span-1 text-center">Треков</div>
            <div class="col-span-1 text-right">Действия</div>
        </div>

        {{-- Строки таблицы (Body) --}}
        <div class="divide-y divide-gray-800/80">
            @forelse($album as $item)
                <div class="grid grid-cols-2 md:grid-cols-12 gap-4 items-center px-6 py-4 hover:bg-main-light/30 transition-colors text-sm">
                    {{-- Обложка --}}
                    <div class="col-span-1">
                        <img src="{{ $item->cover_url }}" alt="{{ $item->title }}" class="w-12 h-12 object-cover rounded-xl border border-gray-700 bg-gray-900">
                    </div>

                    {{-- Название --}}
                    <div class="col-span-3 font-semibold text-white">
                        <a href="{{ route('admin.albums.show', $item) }}" class="hover:text-violet-300 transition-colors truncate block">
                            {{ $item->title }}
                        </a>
                    </div>

                    {{-- Автор --}}
                    <div class="col-span-2 text-gray-400 truncate">
                        {{ $item->author?->name ?? '—' }}
                    </div>

                    {{-- Статус --}}
                    <div class="col-span-2">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $item->status?->name === 'published' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-yellow-950 text-yellow-300 border border-yellow-800' }}">
                            {{ $item->status?->name ?? 'черновик' }}
                        </span>
                    </div>

                    {{-- Дата --}}
                    <div class="col-span-2 text-gray-400">
                        {{ $item->release_date?->format('d.m.Y') ?? '—' }}
                    </div>

                    {{-- Количество треков --}}
                    <div class="col-span-1 text-center font-medium text-gray-300">
                        {{ $item->tracks->count() }}
                    </div>

                    {{-- Кнопки действий --}}
                    <div class="col-span-1 flex items-center justify-end gap-2">
                        <a href="{{ route('admin.albums.edit', $item) }}" class="text-xs text-yellow-400 hover:text-yellow-300 transition-colors p-1.5 hover:bg-yellow-400/10 rounded-lg" title="Редактировать">
                            Изменить
                        </a>
                        <form action="{{ route('admin.albums.destroy', $item) }}" method="POST" onsubmit="return confirm('Удалить альбом?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors p-1.5 hover:bg-red-400/10 rounded-lg cursor-pointer" title="Удалить">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-500">
                    Альбомов пока нет.
                </div>
            @endforelse
        </div>
        {{-- Пагинация --}}
        <div class="mt-6">
            {{ $album->links() }}
        </div>
    </div>
</div>
@endsection
