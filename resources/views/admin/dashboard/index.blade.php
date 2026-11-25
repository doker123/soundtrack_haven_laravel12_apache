@extends('layouts.app')

@section('title', 'Панель администратора — Статистика')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 flex flex-col gap-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-800 pb-6">
        <div>
            <div class="inline-flex items-center gap-2 text-xs font-semibold text-red-400 uppercase tracking-widest bg-red-950/40 border border-red-500/20 px-3 py-1 rounded-full mb-2">
                Администрирование
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Панель управления</h1>
            <p class="text-sm text-gray-400 mt-1">Сводная статистика и количество сущностей в системе Soundtrack Haven</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-main-dark border border-gray-800 text-xs text-gray-300">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Онлайн сейчас: <strong class="text-white">{{ $onlineUsersCount }}</strong>
            </span>
        </div>
    </div>

    {{-- Сетка основных счетчиков --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- 1. Треки --}}
        <a href="{{ route('admin.tracks.index') }}" class="group bg-main-dark border border-gray-800 hover:border-violet-500/50 rounded-2xl p-6 transition-all duration-200 shadow-lg flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-violet-300 transition-colors">Треки</span>
                <div class="w-10 h-10 rounded-xl bg-violet-950/60 border border-violet-500/30 flex items-center justify-center text-violet-400 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                </div>
            </div>
            <div>
                <span class="text-4xl font-extrabold text-white group-hover:text-violet-400 transition-colors">{{ number_format($tracksCount) }}</span>
                <p class="text-xs text-gray-500 mt-1">Всего музыкальных композиций</p>
            </div>
        </a>

        {{-- 2. Альбомы --}}
        <a href="{{ route('admin.albums.index') }}" class="group bg-main-dark border border-gray-800 hover:border-violet-500/50 rounded-2xl p-6 transition-all duration-200 shadow-lg flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-violet-300 transition-colors">Альбомы</span>
                <div class="w-10 h-10 rounded-xl bg-violet-950/60 border border-violet-500/30 flex items-center justify-center text-violet-400 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
            <div>
                <span class="text-4xl font-extrabold text-white group-hover:text-violet-400 transition-colors">{{ number_format($albumsCount) }}</span>
                <p class="text-xs text-gray-500 mt-1">Саундтрек-релизов в каталоге</p>
            </div>
        </a>

        {{-- 3. Авторы --}}
        <a href="{{ route('admin.authors.index') }}" class="group bg-main-dark border border-gray-800 hover:border-violet-500/50 rounded-2xl p-6 transition-all duration-200 shadow-lg flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-violet-300 transition-colors">Авторы</span>
                <div class="w-10 h-10 rounded-xl bg-violet-950/60 border border-violet-500/30 flex items-center justify-center text-violet-400 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <span class="text-4xl font-extrabold text-white group-hover:text-violet-400 transition-colors">{{ number_format($authorsCount) }}</span>
                <p class="text-xs text-gray-500 mt-1">Композиторов и создателей</p>
            </div>
        </a>

        {{-- 4. Плейлисты --}}
        <div class="bg-main-dark border border-gray-800 rounded-2xl p-6 shadow-lg flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Плейлисты</span>
                <div class="w-10 h-10 rounded-xl bg-violet-950/60 border border-violet-500/30 flex items-center justify-center text-violet-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </div>
            </div>
            <div>
                <span class="text-4xl font-extrabold text-white">{{ number_format($playlistsCount) }}</span>
                <p class="text-xs text-gray-500 mt-1">Пользовательских подборок</p>
            </div>
        </div>

        {{-- 5. Пользователи (всего) --}}
        <a href="{{ route('admin.users.index') }}" class="group bg-main-dark border border-gray-800 hover:border-violet-500/50 rounded-2xl p-6 transition-all duration-200 shadow-lg flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-violet-300 transition-colors">Пользователи</span>
                <div class="w-10 h-10 rounded-xl bg-violet-950/60 border border-violet-500/30 flex items-center justify-center text-violet-400 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <span class="text-4xl font-extrabold text-white group-hover:text-violet-400 transition-colors">{{ number_format($usersCount) }}</span>
                <p class="text-xs text-gray-500 mt-1">Зарегистрированных аккаунтов (активных: {{ $unbannedUsersCount }})</p>
            </div>
        </a>

        {{-- 6. Активные пользователи (Online) --}}
        <div class="bg-main-dark border border-emerald-900/40 rounded-2xl p-6 shadow-lg flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Активные онлайн</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-950/60 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                </div>
            </div>
            <div>
                <span class="text-4xl font-extrabold text-emerald-400">{{ number_format($onlineUsersCount) }}</span>
                <p class="text-xs text-gray-400 mt-1">Пользователей за последние 15 минут</p>
            </div>
        </div>
    </div>

    {{-- Быстрые переходы и заявки --}}
    <div class="bg-main-dark border border-gray-800 rounded-2xl p-6 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gray-900 border border-gray-700 flex items-center justify-center text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-white text-base">Заявки на разбан</h3>
                <p class="text-xs text-gray-400">Ожидают проверки администратором: <strong class="text-white">{{ $pendingAppealsCount }}</strong></p>
            </div>
        </div>
        <a href="{{ route('admin.appeals.index') }}" class="w-full sm:w-auto text-center bg-violet-600 hover:bg-violet-700 text-white text-xs font-semibold px-5 py-2.5 rounded-xl transition-colors">
            Перейти к апелляциям →
        </a>
    </div>
</div>
@endsection
