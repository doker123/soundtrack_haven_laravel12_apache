@extends('layouts.app')

@section('title', 'Админ: Авторы')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-violet-400 font-semibold uppercase tracking-wider mb-1">
                <span>Панель управления</span>
                <span>/</span>
                <span>Авторы</span>
            </div>
            <h1 class="text-3xl font-extrabold text-white">Композиторы и авторы</h1>
        </div>

        <a href="{{ route('admin.authors.create') }}"
           class="bg-[#6d5898] hover:bg-[#5825b5] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg flex items-center gap-2">
            + Добавить автора
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Сетка-таблица авторов --}}
    <div class="bg-main-dark border border-gray-800 rounded-3xl overflow-hidden shadow-xl">
        {{-- Header --}}
        <div class="hidden md:grid grid-cols-12 gap-4 items-center px-6 py-4 bg-main-light/60 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-800">
            <div class="col-span-1">Аватар</div>
            <div class="col-span-4">Имя автора</div>
            <div class="col-span-3">Альбомов</div>
            <div class="col-span-2">Треков</div>
            <div class="col-span-2 text-right">Действия</div>
        </div>

        {{-- Body --}}
        <div class="divide-y divide-gray-800/80">
            @forelse($authors as $author)
                <div class="grid grid-cols-2 md:grid-cols-12 gap-4 items-center px-6 py-3.5 hover:bg-main-light/30 transition-colors text-sm">
                    {{-- Аватар --}}
                    <div class="col-span-1">
                        <img src="{{ $author->image_url }}" alt="{{ $author->name }}" class="w-10 h-10 object-cover rounded-full border border-gray-700 bg-gray-900">
                    </div>

                    {{-- Имя --}}
                    <div class="col-span-4 font-semibold text-white truncate">
                        <a href="{{ route('admin.authors.show', $author) }}" class="hover:text-violet-300 transition-colors">
                            {{ $author->name }}
                        </a>
                    </div>

                    {{-- Альбомов --}}
                    <div class="col-span-3 text-gray-400">
                        {{ $author->albums->count() }} альбомов
                    </div>

                    {{-- Треков --}}
                    <div class="col-span-2 text-gray-400">
                        {{ $author->tracks->count() }} треков
                    </div>

                    {{-- Действия --}}
                    <div class="col-span-2 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.authors.edit', $author) }}" class="text-xs text-yellow-400 hover:text-yellow-300 hover:underline">
                            Изменить
                        </a>
                        <form action="{{ route('admin.authors.destroy', $author) }}" method="POST">
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
                    Авторов пока нет.
                </div>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $authors->links() }}
        </div>
    </div>
</div>
@endsection
