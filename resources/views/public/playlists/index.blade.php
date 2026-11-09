@extends('layouts.app')

@section('title', 'Мои плейлисты')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-white">Мои плейлисты</h1>
            <p class="text-sm text-gray-400 mt-1">Созданные вами подборки музыки</p>
        </div>

        <a href="{{ route('playlists.create') }}"
           class="bg-[#6d5898] hover:bg-[#5825b5] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-2">
            + Создать плейлист
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @forelse($playlists as $playlist)
            <div class="bg-main-dark border border-gray-800 rounded-2xl p-4 flex flex-col hover:border-violet-500/50 transition-all group">
                <a href="{{ route('playlists.show', $playlist) }}" class="overflow-hidden rounded-xl mb-3 block aspect-square bg-gray-900">
                    <img src="{{ $playlist->cover_url }}" alt="{{ $playlist->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </a>

                <h3 class="font-bold text-white text-base truncate">
                    <a href="{{ route('playlists.show', $playlist) }}" class="hover:text-violet-300 transition-colors">
                        {{ $playlist->title }}
                    </a>
                </h3>

                <div class="mt-auto pt-3 flex items-center justify-between text-xs text-gray-400">
                    <span>{{ $playlist->tracks_count }} треков</span>
                    <span>{{ $playlist->is_public ? 'Публичный' : 'Приватный' }}</span>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-gray-400 bg-main-dark border border-gray-800 rounded-3xl">
                У вас пока нет плейлистов. Нажмите «Создать плейлист», чтобы собрать первый!
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $playlists->links() }}
    </div>
</div>
@endsection
