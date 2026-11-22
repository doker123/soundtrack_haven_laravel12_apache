@extends('layouts.app')

@section('title', 'Аккаунт заблокирован — Soundtrack Haven')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12 flex flex-col gap-8">
    {{-- Карточка блокировки --}}
    <div class="bg-main-dark border border-red-500/40 rounded-3xl p-6 md:p-8 flex flex-col gap-6 shadow-2xl">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-red-500/10 border border-red-500/30 flex items-center justify-center shrink-0 text-red-400">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-black text-white">Доступ к аккаунту ограничен</h1>
                <p class="text-xs text-red-300 mt-1">Ваш аккаунт был временно или навсегда заблокирован администрацией</p>
            </div>
        </div>

        {{-- Детали бана --}}
        <div class="bg-main-light/30 border border-gray-800 rounded-2xl p-4 flex flex-col gap-3 text-sm">
            <div class="flex flex-col sm:flex-row sm:justify-between gap-1 border-b border-gray-800/80 pb-2">
                <span class="text-gray-400">Пользователь:</span>
                <span class="text-white font-medium truncate">{{ $user->name }} ({{ $user->email }})</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between gap-1 border-b border-gray-800/80 pb-2">
                <span class="text-gray-400">Срок блокировки:</span>
                <span class="font-semibold {{ $activeBan?->isPermanent() ? 'text-red-400' : 'text-amber-400' }}">
                    {{ $activeBan?->isPermanent() ? 'Навсегда (Перманентный бан)' : 'До ' . $activeBan?->expires_at?->format('d.m.Y H:i') }}
                </span>
            </div>
            <div class="flex flex-col gap-1 pt-1">
                <span class="text-gray-400">Причина блокировки:</span>
                <p class="text-gray-200 bg-main-dark/80 p-3 rounded-xl border border-gray-800/80 text-sm whitespace-pre-wrap">
                    {{ $activeBan?->reason ?? 'Нарушение правил сообщества.' }}
                </p>
            </div>
        </div>

        {{-- Уведомления --}}
        @if(session('status'))
            <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-300 text-sm">
                {{ session('status') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-2xl text-red-300 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Если апелляция уже подана и ожидает решения --}}
        @if($latestAppeal && $latestAppeal->isPending())
            <div class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-5 flex flex-col gap-2">
                <div class="flex items-center gap-2 text-amber-400 font-semibold text-sm">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Ваше заявление находится на рассмотрении</span>
                </div>
                <p class="text-xs text-gray-300 leading-relaxed">
                    Вы подали апелляцию {{ $latestAppeal->created_at->diffForHumans() }}. Модератор проверит её в ближайшее время. Пожалуйста, ожидайте решения.
                </p>
                <div class="mt-2 p-3 bg-main-dark/60 rounded-xl border border-gray-800 text-xs text-gray-300">
                    <span class="text-gray-400 block mb-1">Ваш текст:</span>
                    {{ $latestAppeal->reason }}
                </div>
            </div>
        {{-- Если апелляция была отклонена --}}
        @elseif($latestAppeal && $latestAppeal->isRejected())
            <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-5 flex flex-col gap-2">
                <div class="flex items-center gap-2 text-red-400 font-semibold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Апелляция была отклонена</span>
                </div>
                @if($latestAppeal->admin_comment)
                    <p class="text-xs text-gray-300">
                        <span class="text-gray-400">Ответ модератора:</span>
                        {{ $latestAppeal->admin_comment }}
                    </p>
                @endif
                <p class="text-[11px] text-gray-500">
                    Рассмотрено: {{ $latestAppeal->reviewed_at?->format('d.m.Y H:i') }}
                </p>
            </div>
        @endif

        {{-- Форма обжалования (доступна, если нет активной заявки на рассмотрении) --}}
        @if(!$latestAppeal || !$latestAppeal->isPending())
            <form action="{{ route('public.ban.appeal') }}" method="POST" class="flex flex-col gap-6 pt-2">
                @csrf
                <div>
                    <label for="reason" class="block text-sm font-semibold text-gray-300 mb-3">
                        Заявление на обжалование блокировки
                    </label>
                    <textarea id="reason"
                              name="reason"
                              rows="5"
                              placeholder="Опишите, почему вы считаете блокировку ошибочной, или предоставьте дополнительную информацию для администрации..."
                              class="w-full bg-main-light/40 border border-gray-700 focus:border-violet-500 focus:ring-1 focus:ring-violet-500 rounded-2xl p-5 text-sm text-white placeholder-gray-500 outline-none transition resize-none leading-relaxed @error('reason') border-red-500 @enderror">{{ old('reason') }}</textarea>
                    @error('reason')
                        <span class="text-xs text-red-400 mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between gap-4 pt-3">
                    <a href="#"
                       onclick="event.preventDefault(); document.getElementById('banned-logout-form').submit();"
                       class="text-xs text-gray-400 hover:text-white transition">
                        Выйти из аккаунта
                    </a>

                    <button type="submit"
                            class="px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white font-semibold text-sm rounded-xl shadow-lg transition">
                        Отправить апелляцию
                    </button>
                </div>
            </form>
        @else
            <div class="pt-2">
                <a href="#"
                   onclick="event.preventDefault(); document.getElementById('banned-logout-form').submit();"
                   class="text-xs text-gray-400 hover:text-white transition block text-right">
                    Выйти из аккаунта
                </a>
            </div>
        @endif

        <form id="banned-logout-form" action="{{ route('public.logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>
@endsection
