@extends('layouts.app')

@section('title', 'Админ: Пользователи')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-violet-400 font-semibold uppercase tracking-wider mb-1">
                <span>Панель управления</span>
                <span>/</span>
                <span>Пользователи</span>
            </div>
            <h1 class="text-3xl font-extrabold text-white">Пользователи</h1>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-950/60 border border-red-500/40 text-red-300 text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Фильтры --}}
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-6
                 bg-main-dark border border-gray-800 rounded-2xl p-4 shadow-xl">

        <div class="md:col-span-6">
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">
                Поиск
            </label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Имя или email"
                   class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-3 py-2
                          text-sm text-white placeholder-gray-500
                          focus:border-violet-500 focus:outline-none">
        </div>

        <div class="md:col-span-3">
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">
                Роль
            </label>
            <select name="role_id"
                    class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-3 py-2
                           text-sm text-white focus:border-violet-500 focus:outline-none">
                <option class="bg-[#2e2d4d]" value="">— Все —</option>
                @foreach($roles as $role)
                    <option class="bg-[#2e2d4d]" value="{{ $role->id }}" @selected(request('role_id') == $role->id)>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-3 grid grid-cols-2 gap-2 items-end">
            <button type="submit"
                    class="bg-[#6d5898] hover:bg-[#5825b5] text-white text-sm font-semibold
                           px-4 py-2 rounded-xl transition-all shadow-lg">
                Применить
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="text-center border border-gray-700 text-gray-300 text-sm font-semibold
                      px-4 py-2 rounded-xl hover:bg-main-light/40 transition-colors">
                Сбросить
            </a>
        </div>
    </form>

    {{-- Grid-таблица --}}
    <div class="bg-main-dark border border-gray-800 rounded-3xl overflow-hidden shadow-xl">

        {{-- Header --}}
        <div class="hidden md:grid grid-cols-12 gap-4 items-center px-6 py-4
                    bg-main-light/60 text-xs font-semibold text-gray-400 uppercase tracking-wider
                    border-b border-gray-800">
            <div class="col-span-1">Аватар</div>
            <div class="col-span-4">Пользователь</div>
            <div class="col-span-2">Роль</div>
            <div class="col-span-3">Статус</div>
            <div class="col-span-2 text-right">Действия</div>
        </div>

        {{-- Body --}}
        <div class="divide-y divide-gray-800/80">
            @forelse($users as $user)
                @php
                    $activeBan = $user->bans->first(fn ($b) => $b->isActive());
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-12 gap-4 items-center
                            px-6 py-3.5 hover:bg-main-light/30 transition-colors text-sm">

                    {{-- Аватар --}}
                    <div class="col-span-1">
                        <img src="{{ $user->avatar?->url ?? asset('images/default-avatar.png') }}"
                             alt="{{ $user->name }}"
                             class="w-10 h-10 object-cover rounded-full
                                    border border-gray-700 bg-gray-900">
                    </div>

                    {{-- Пользователь --}}
                    <div class="col-span-4 min-w-0">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="font-semibold text-white hover:text-violet-300 transition-colors truncate block">
                            {{ $user->name }}
                        </a>
                        <div class="text-xs text-gray-500 truncate">{{ $user->email }}</div>
                    </div>

                    {{-- Роль --}}
                    <div class="col-span-2">
                        <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-semibold
                                     bg-violet-950/60 text-violet-300 border border-violet-500/30">
                            {{ $user->role?->name ?? '—' }}
                        </span>
                    </div>

                    {{-- Статус --}}
                    <div class="col-span-3">
                        @if($activeBan)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold
                                         bg-red-950/60 text-red-300 border border-red-500/40">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                Забанен
                            </span>
                            <div class="text-[11px] text-gray-500 mt-1 truncate" title="{{ $activeBan->reason }}">
                                @if($activeBan->expires_at)
                                    до {{ $activeBan->expires_at->format('d.m.Y H:i') }}
                                @else
                                    бессрочно
                                @endif
                            </div>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold
                                         bg-emerald-950/60 text-emerald-300 border border-emerald-500/40">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                Активен
                            </span>
                        @endif
                    </div>

                    {{-- Действия --}}
                    <div class="col-span-2 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="text-xs text-yellow-400 hover:text-yellow-300 hover:underline">
                            Открыть
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-xs text-red-400 hover:text-red-300 hover:underline cursor-pointer">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-500">
                    Пользователей не найдено.
                </div>
            @endforelse
        </div>
    </div>
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
