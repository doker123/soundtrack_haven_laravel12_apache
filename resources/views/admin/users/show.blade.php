@extends('layouts.app')

@section('title', "Пользователь: {$user->name}")

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- Хлебные крошки и заголовок --}}
    <div class="grid grid-cols-1 md:grid-cols-[1fr_auto] gap-3 items-center mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-violet-400 font-semibold uppercase tracking-wider mb-1">
                <span>Панель управления</span>
                <span>/</span>
                <a href="{{ route('admin.users.index') }}" class="hover:text-violet-300">Пользователи</a>
                <span>/</span>
                <span>{{ $user->name }}</span>
            </div>
            <h1 class="text-3xl font-extrabold text-white truncate">
                {{ $user->name }}
            </h1>
        </div>
        <a href="{{ route('admin.users.index') }}"
           class="md:justify-self-end text-sm font-semibold text-gray-300
                  border border-gray-700 px-4 py-2 rounded-xl hover:bg-main-light/40 transition-colors">
            ← К списку
        </a>
    </div>

    {{-- Уведомления --}}
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

    {{-- Двухколоночная сетка --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- ═════════ САЙДБАР (4/12) ═════════ --}}
        <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-6">

            {{-- Карточка профиля --}}
            <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 shadow-xl
                        grid grid-cols-[auto_1fr] gap-4 items-center">
                <img src="{{ $user->avatar?->url ?? asset('images/default-avatar.png') }}"
                     alt="{{ $user->name }}"
                     class="w-16 h-16 rounded-full object-cover border border-gray-700 bg-gray-900">

                <div class="min-w-0">
                    <div class="font-semibold text-white truncate">{{ $user->name }}</div>
                    <div class="text-sm text-gray-400 truncate">{{ $user->email }}</div>
                </div>

                <div class="col-span-2 grid grid-cols-2 gap-4 pt-4 border-t border-gray-800 text-sm">
                    <div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Роль</div>
                        <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-semibold
                                     bg-violet-950/60 text-violet-300 border border-violet-500/30">
                            {{ $user->role?->name ?? '—' }}
                        </span>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">ID</div>
                        <div class="text-white">{{ $user->id }}</div>
                    </div>
                    <div class="col-span-2">
                        <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Регистрация</div>
                        <div class="text-white">{{ $user->created_at?->format('d.m.Y H:i') }}</div>
                    </div>
                </div>
            </div>

            {{-- Статус бана --}}
            @php $activeBan = $user->activeBan(); @endphp
            <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 shadow-xl">
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Статус аккаунта</h2>

                @if($activeBan)
                    <div class="rounded-2xl bg-red-950/40 border border-red-500/40 p-4 text-sm space-y-2">
                        <div class="flex items-center gap-2 text-red-300 font-semibold">
                            <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                            Активный бан
                        </div>
                        <div class="text-gray-300">
                            <span class="text-gray-500">Причина:</span> {{ $activeBan->reason }}
                        </div>
                        <div class="text-gray-300">
                            <span class="text-gray-500">Модератор:</span> {{ $activeBan->bannedBy?->name ?? '—' }}
                        </div>
                        <div class="text-gray-300">
                            <span class="text-gray-500">Срок:</span>
                            @if($activeBan->expires_at)
                                до {{ $activeBan->expires_at->format('d.m.Y H:i') }}
                                <span class="text-gray-500">({{ $activeBan->expires_at->diffForHumans() }})</span>
                            @else
                                бессрочно
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 pt-2 border-t border-red-500/20">
                            Выдан: {{ $activeBan->created_at?->format('d.m.Y H:i') }}
                        </div>
                    </div>

                    {{-- Кнопка разбана (POST запрос без @method('PATCH')) --}}
                    <form action="{{ route('admin.users.unban', $user) }}" method="POST"
                          class="mt-4">
                        @csrf
                        <button type="submit"
                                class="w-full bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold
                                       px-4 py-2.5 rounded-xl transition-all shadow-lg cursor-pointer">
                            Снять бан
                        </button>
                    </form>
                @else
                    <div class="rounded-2xl bg-emerald-950/40 border border-emerald-500/40 p-4">
                        <div class="flex items-center gap-2 text-emerald-300 font-semibold text-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Активен (нет банов)
                        </div>
                    </div>
                @endif
            </div>

            {{-- Опасная зона (Удаление) --}}
            <div class="bg-main-dark border border-red-500/30 rounded-3xl p-6 shadow-xl">
                <h2 class="text-xs font-semibold text-red-400 uppercase tracking-wider mb-3">Опасная зона</h2>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full border border-red-500/60 text-red-400 text-sm font-semibold
                                   px-4 py-2.5 rounded-xl hover:bg-red-950/40 transition-colors cursor-pointer">
                        Удалить пользователя
                    </button>
                </form>
            </div>
        </aside>

        {{-- ═════════ ОСНОВНОЙ КОНТЕНТ (8/12) ═════════ --}}
        <main class="lg:col-span-8 space-y-6">

            {{-- Смена роли --}}
            <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 shadow-xl">
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Изменение роли</h2>
                <form action="{{ route('admin.users.update', $user) }}" method="POST"
                      class="grid grid-cols-1 sm:grid-cols-[1fr_auto] gap-3 items-start">
                    @csrf
                    @method('PUT')

                    <div>
                        <select name="role_id"
                                class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-3 py-2.5
                                       text-sm text-white focus:border-violet-500 focus:outline-none">
                            @foreach($roles ?? \App\Models\Role::all() as $role)
                                <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="text-sm text-red-400 mt-1.5">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit"
                            class="bg-[#6d5898] hover:bg-[#5825b5] text-white text-sm font-semibold
                                   px-5 py-2.5 rounded-xl transition-all shadow-lg cursor-pointer">
                        Сохранить
                    </button>
                </form>
            </div>

            {{-- Форма выдачи бана --}}
            @if(! $activeBan)
                <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 shadow-xl">
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Заблокировать пользователя</h2>
                    <form action="{{ route('admin.users.ban', $user) }}" method="POST"
                          class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @csrf

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">
                                Причина бана *
                            </label>
                            <textarea name="reason" rows="3" required
                                      class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-3 py-2.5
                                             text-sm text-white placeholder-gray-500
                                             focus:border-violet-500 focus:outline-none"
                                      placeholder="Укажите конкретную причину блокировки">{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="text-sm text-red-400 mt-1.5">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">
                                Срок бана (оставьте пустым для бессрочного)
                            </label>
                            <input type="datetime-local" name="expires_at"
                                   value="{{ old('expires_at') }}"
                                   class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-3 py-2.5
                                          text-sm text-white focus:border-violet-500 focus:outline-none">
                            @error('expires_at')
                                <div class="text-sm text-red-400 mt-1.5">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-500 text-white text-sm font-semibold
                                           px-5 py-2.5 rounded-xl transition-all shadow-lg cursor-pointer">
                                Выдать бан
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- История всех банов --}}
            @if($user->bans->isNotEmpty())
                <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 shadow-xl">
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">История банов</h2>
                    <ul class="grid grid-cols-1 gap-2">
                        @foreach($user->bans->sortByDesc('id') as $ban)
                            <li class="grid grid-cols-[auto_1fr] gap-3 items-start
                                       rounded-2xl border px-4 py-3
                                       {{ $ban->isActive()
                                            ? 'bg-red-950/30 border-red-500/40'
                                            : 'bg-main-light/30 border-gray-800' }}">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg shrink-0
                                             {{ $ban->isActive()
                                                  ? 'bg-red-600 text-white'
                                                  : 'bg-gray-700 text-gray-300' }}">
                                    {{ $ban->isActive() ? 'Активен' : 'Истёк' }}
                                </span>
                                <div class="min-w-0">
                                    <div class="text-sm text-white font-medium">{{ $ban->reason }}</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $ban->created_at?->format('d.m.Y H:i') }}
                                        @if($ban->expires_at)
                                            · до {{ $ban->expires_at->format('d.m.Y H:i') }}
                                        @else
                                            · бессрочно
                                        @endif
                                        · модератор: {{ $ban->bannedBy?->name ?? '—' }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection