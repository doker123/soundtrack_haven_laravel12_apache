@extends('layouts.app')

@section('title', 'Редактировать автора: ' . $author->name)

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.authors.index') }}" class="text-xs text-gray-400 hover:text-white transition-colors">
            ← Вернуться к списку авторов
        </a>
        <h1 class="text-3xl font-bold text-white mt-2">Редактировать автора</h1>
    </div>

    <div class="bg-main-dark border border-gray-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('admin.authors.update', $author) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Имя --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Имя автора *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $author->name) }}" required
                       class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500 transition-colors">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Биография --}}
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">Биография</label>
                <textarea id="bio" name="bio" rows="5"
                          class="w-full bg-main-light border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-violet-500 transition-colors">{{ old('bio', $author->bio) }}</textarea>
                @error('bio') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Кнопки --}}
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-800">
                <a href="{{ route('admin.authors.index') }}" class="px-5 py-2.5 text-sm text-gray-400 hover:text-white transition-colors">
                    Отмена
                </a>
                <button type="submit" 
                        class="bg-[#6d5898] hover:bg-[#5825b5] text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md">
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</div>
@endsection