@extends('layouts.app')
@section('title', 'Заявки на разбан — Админ-панель')
@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 flex flex-col gap-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-white">Заявки на разбан</h1>
            <p class="text-sm text-gray-400 mt-1">Рассмотрение и обработка апелляций заблокированных пользователей</p>
        </div>
        <div class="flex items-center gap-2 bg-main-dark p-1.5 rounded-2xl border border-gray-800 self-start md:self-auto">
            <a href="{{ route('admin.appeals.index', ['status' => 'pending']) }}"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-2 {{ $status === 'pending' ? 'bg-violet-600 text-white shadow-lg' : 'text-gray-400 hover:text-white' }}">
                <span>Ожидают</span>
                @if($counts['pending'] > 0)
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $status === 'pending' ? 'bg-white/20' : 'bg-amber-500/20 text-amber-300' }}">
                        {{ $counts['pending'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.appeals.index', ['status' => 'approved']) }}"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-2 {{ $status === 'approved' ? 'bg-violet-600 text-white shadow-lg' : 'text-gray-400 hover:text-white' }}">
                <span>Одобренные</span>
                <span class="text-gray-400 text-[10px]">({{ $counts['approved'] }})</span>
            </a>
            <a href="{{ route('admin.appeals.index', ['status' => 'rejected']) }}"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-2 {{ $status === 'rejected' ? 'bg-violet-600 text-white shadow-lg' : 'text-gray-400 hover:text-white' }}">
                <span>Отклонённые</span>
                <span class="text-gray-400 text-[10px]">({{ $counts['rejected'] }})</span>
            </a>
            <a href="{{ route('admin.appeals.index', ['status' => 'all']) }}"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ $status === 'all' ? 'bg-violet-600 text-white shadow-lg' : 'text-gray-400 hover:text-white' }}">
                Все ({{ $counts['all'] }})
            </a>
        </div>
    </div>
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-2xl text-red-300 text-sm">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex flex-col gap-4">
        @forelse($appeals as $appeal)
            <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 flex flex-col gap-5 hover:border-gray-700 transition">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-800/80 pb-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-gray-900 border border-gray-700 overflow-hidden shrink-0">
                            <img src="{{ $appeal->user->avatar_url ?? asset('images/default-avatar.svg') }}"
                                 alt="{{ $appeal->user->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.show', $appeal->user) }}" class="font-bold text-white hover:text-violet-400 transition text-sm">
                                    {{ $appeal->user->name }}
                                </a>
                                <span class="text-xs text-gray-400">({{ $appeal->user->email }})</span>
                            </div>
                            <span class="text-[11px] text-gray-500">Подано: {{ $appeal->created_at->format('d.m.Y H:i') }} ({{ $appeal->created_at->diffForHumans() }})</span>
                        </div>
                    </div>
                    <div>
                        @if($appeal->isPending())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 rounded-xl text-xs font-semibold">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                На рассмотрении
                            </span>
                        @elseif($appeal->isApproved())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 rounded-xl text-xs font-semibold">
                                ✓ Одобрено (Разбанен)
                            </span>
                        @elseif($appeal->isRejected())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-500/10 border border-red-500/30 text-red-300 rounded-xl text-xs font-semibold">
                                ✕ Отклонено
                            </span>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div class="bg-main-light/30 border border-gray-800/80 rounded-2xl p-4 flex flex-col gap-2">
                        <span class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Информация о блокировке</span>
                        <div class="text-gray-300 flex flex-col gap-1 mt-1">
                            <div><span class="text-gray-500">Кем забанен:</span> {{ $appeal->ban?->bannedBy?->name ?? 'Система' }}</div>
                            <div><span class="text-gray-500">Срок:</span>
                                <span class="{{ $appeal->ban?->isPermanent() ? 'text-red-400 font-semibold' : 'text-amber-400' }}">
                                    {{ $appeal->ban?->isPermanent() ? 'Перманентно' : 'До ' . $appeal->ban?->expires_at?->format('d.m.Y H:i') }}
                                </span>
                            </div>
                            <div class="mt-1">
                                <span class="text-gray-500 block mb-1">Причина бана:</span>
                                <p class="text-gray-200 bg-main-dark/80 p-2.5 rounded-xl border border-gray-800">
                                    {{ $appeal->ban?->reason ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-main-light/30 border border-gray-800/80 rounded-2xl p-4 flex flex-col gap-2">
                        <span class="text-violet-400 font-semibold uppercase tracking-wider text-[10px]">Заявление пользователя</span>
                        <div class="mt-1">
                            <p class="text-gray-200 bg-main-dark/80 p-3 rounded-xl border border-gray-800 whitespace-pre-wrap leading-relaxed">
                                {{ $appeal->reason }}
                            </p>
                        </div>
                        @if(!$appeal->isPending())
                            <div class="mt-auto pt-2 border-t border-gray-800 text-[11px] text-gray-400 flex flex-col gap-1">
                                <div><span class="text-gray-500">Рассмотрел:</span> {{ $appeal->reviewedBy?->name ?? 'Модератор' }} ({{ $appeal->reviewed_at?->format('d.m.Y H:i') }})</div>
                                @if($appeal->admin_comment)
                                    <div><span class="text-gray-500">Комментарий:</span> {{ $appeal->admin_comment }}</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                @if($appeal->isPending())
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-2 border-t border-gray-800/80">
                        <form action="{{ route('admin.appeals.reject', $appeal) }}" method="POST" class="inline flex-1 sm:flex-initial">
                            @csrf
                            <input type="hidden" name="admin_comment" value="В разбане отказано после рассмотрения апелляции.">
                            <button type="submit"
                                    class="w-full sm:w-auto px-4 py-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/30 text-red-300 rounded-xl text-xs font-semibold transition">
                                Отклонить
                            </button>
                        </form>
                        <form action="{{ route('admin.appeals.approve', $appeal) }}" method="POST" class="inline flex-1 sm:flex-initial">
                            @csrf
                            <input type="hidden" name="admin_comment" value="Апелляция принята. Ограничения с аккаунта сняты.">
                            <button type="submit"
                                    class="w-full sm:w-auto px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-lg transition">
                                Одобрить и разбанить
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="py-16 text-center text-gray-500 bg-main-dark border border-gray-800 rounded-3xl">
                В этой категории пока нет заявок.
            </div>
        @endforelse
    </div>
    @if($appeals->hasPages())
        <div class="mt-4">
            {{ $appeals->links() }}
        </div>
    @endif
</div>
@endsection
