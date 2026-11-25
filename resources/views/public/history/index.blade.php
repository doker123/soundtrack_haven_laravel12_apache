@extends('layouts.app')
@section('title', 'История прослушиваний')
@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-white">История прослушиваний</h1>
        <p class="text-sm text-gray-400 mt-1">Все треки, которые вы слушали</p>
    </div>
    <div class="grid grid-cols-3 gap-4 mb-10">
        <div class="bg-main-dark border border-gray-800 rounded-2xl p-5 flex flex-col gap-1">
            <span class="text-3xl font-extrabold text-violet-400">{{ number_format($totalPlays) }}</span>
            <span class="text-sm text-gray-400">всего прослушиваний</span>
        </div>
        <div class="bg-main-dark border border-gray-800 rounded-2xl p-5 flex flex-col gap-1">
            <span class="text-3xl font-extrabold text-violet-400">{{ $uniqueTracks }}</span>
            <span class="text-sm text-gray-400">уникальных треков</span>
        </div>
        <div class="bg-main-dark border border-gray-800 rounded-2xl p-5 flex flex-col gap-1">
            @php
                $totalMin = (int)($totalMs / 60000);
                $totalHours = floor($totalMin / 60);
                $remainMin  = $totalMin % 60;
            @endphp
            <span class="text-3xl font-extrabold text-violet-400">
                {{ $totalHours > 0 ? $totalHours . 'ч ' : '' }}{{ $remainMin }}м
            </span>
            <span class="text-sm text-gray-400">времени прослушано</span>
        </div>
    </div>
    <div class="flex flex-col gap-2">
        @forelse($history as $entry)
            @php
                $track = $entry->track;
                $percent = $entry->listenedPercent();
            @endphp
            <div class="bg-main-dark border border-gray-800 hover:border-violet-500/40 rounded-2xl p-3 flex items-center gap-4 transition-colors group cursor-pointer"
                 data-track-id="{{ $track->id }}"
                 data-track-url="{{ route('tracks.stream', $track) }}"
                 data-track-title="{{ $track->title }}"
                 data-track-author="{{ $track->author?->name ?? 'Неизвестный автор' }}"
                 data-track-cover="{{ $track->album?->cover_url ?? asset('images/default-cover.svg') }}"
                 data-track-duration="{{ $track->duration_ms ? (int)($track->duration_ms / 1000) : 0 }}">
                <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 shrink-0 border border-gray-700/60">
                    <img src="{{ $track->album?->cover_url ?? asset('images/default-cover.svg') }}"
                         alt="{{ $track->title }}"
                         class="w-full h-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-white text-sm truncate group-hover:text-violet-300 transition-colors">
                        {{ $track->title }}
                    </h4>
                    <p class="text-xs text-gray-400 truncate mt-0.5">
                        {{ $track->author?->name ?? '—' }}
                        @if($track->album)
                            · <span class="text-gray-500">{{ $track->album->title }}</span>
                        @endif
                    </p>
                    <div class="mt-1.5 flex items-center gap-2">
                        <div class="flex-1 h-1 bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-violet-500 rounded-full transition-all"
                                 style="width: {{ $percent }}%"></div>
                        </div>
                        <span class="text-[10px] text-gray-500 shrink-0">{{ $percent }}%</span>
                    </div>
                </div>
                <div class="shrink-0 text-right flex flex-col items-end gap-1">
                    <span class="text-xs font-mono text-gray-500">
                        {{ $track->duration_ms ? gmdate('i:s', (int)($track->duration_ms / 1000)) : '—' }}
                    </span>
                    <span class="text-[11px] text-gray-600" title="{{ $entry->played_at->format('d.m.Y H:i:s') }}">
                        {{ $entry->played_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        @empty
            <div class="py-20 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-3xl flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-900 border border-gray-800 flex items-center justify-center text-gray-500 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                </div>
                <p class="text-lg font-semibold text-gray-400">Вы ещё ничего не слушали</p>
                <p class="text-sm text-gray-600 mt-1">Начните с главной страницы или любого альбома</p>
                <a href="{{ route('home') }}"
                   class="mt-6 inline-block bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-all">
                    На главную
                </a>
            </div>
        @endforelse
    </div>
    @if($history->hasPages())
        <div class="mt-8">
            {{ $history->links() }}
        </div>
    @endif
</div>
@endsection
