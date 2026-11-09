@extends('layouts.app')

@section('title', 'Настройки аккаунта')

@section('content')
    <div class="max-w-7xl mx-auto flex flex-col gap-5">

        <div>
            <h1 class="text-3xl font-extrabold text-white">Настройки профиля</h1>
            <p class="text-sm text-gray-400 mt-1">Персонализация профиля и параметры безопасности</p>
        </div>

        <div class="flex flex-col gap-4">
            {{-- 1. Карточка Аватара --}}
            <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 md:p-8 shadow-xl">
                <h2 class="text-lg font-bold text-white mb-4">Аватар профиля</h2>

                @if(session('avatar_success'))
                    <div class="mb-4 p-3 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-xs">
                        {{ session('avatar_success') }}
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <img src="{{ $user->getAvatar() }}"
                         alt="{{ $user->name }}"
                         class="w-20 h-20 rounded-full object-cover border-2 border-violet-500/40 bg-gray-900 shadow-md shrink-0">

                    <div class="flex-1 w-full">
                        <form action="{{ route('public.settings.avatar.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                            @csrf
                            <input type="file"
                                   name="avatar"
                                   id="avatar"
                                   accept="image/png, image/jpeg, image/webp"
                                   required
                                   class="w-full text-xs text-gray-400 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-violet-600 file:text-white hover:file:bg-violet-700 cursor-pointer">

                            <button type="submit" class="bg-[#6d5898] hover:bg-[#5825b5] text-white px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap cursor-pointer">
                                Загрузить
                            </button>
                        </form>
                        @error('avatar')
                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($user->avatar)
                        <form action="{{ route('public.settings.avatar.delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300 hover:underline cursor-pointer">
                                Удалить фото
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                {{-- 2. Карточка Никнейма --}}
                <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 md:p-8 shadow-xl">
                    <h2 class="text-lg font-bold text-white mb-4">Никнейм</h2>

                    @if(session('name_success'))
                        <div class="mb-4 p-3 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-xs">
                            {{ session('name_success') }}
                        </div>
                    @endif

                    <form action="{{ route('public.settings.name.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   placeholder="Ваш никнейм"
                                   class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-violet-500">
                            @error('name')
                            <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-[#6d5898] hover:bg-[#5825b5] text-white px-5 py-2 rounded-xl text-xs font-semibold cursor-pointer">
                                Сохранить имя
                            </button>
                        </div>
                    </form>
                </div>

                {{-- 3. Карточка Email --}}
                <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 md:p-8 shadow-xl">
                    <h2 class="text-lg font-bold text-white mb-4">Электронная почта</h2>

                    @if(session('email_success'))
                        <div class="mb-4 p-3 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-xs">
                            {{ session('email_success') }}
                        </div>
                    @endif

                    <form action="{{ route('public.settings.email.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   required
                                   placeholder="example@mail.com"
                                   class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-violet-500">
                            @error('email')
                            <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-[#6d5898] hover:bg-[#5825b5] text-white px-5 py-2 rounded-xl text-xs font-semibold cursor-pointer">
                                Сохранить email
                            </button>
                        </div>
                    </form>
                </div>

                {{-- 4. Карточка Пароля --}}
                <div class="bg-main-dark border border-gray-800 rounded-3xl p-6 md:p-8 shadow-xl">
                    <h2 class="text-lg font-bold text-white mb-4">Безопасность (Смена пароля)</h2>

                    @if(session('password_success'))
                        <div class="mb-4 p-3 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-xs">
                            {{ session('password_success') }}
                        </div>
                    @endif

                    <form action="{{ route('public.settings.password.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs text-gray-400 mb-1">Текущий пароль</label>
                            <input type="password"
                                   name="current_password"
                                   required
                                   class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-violet-500">
                            @error('current_password')
                            <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-400 mb-1">Новый пароль</label>
                                <input type="password"
                                       name="password"
                                       required
                                       class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-violet-500">
                                @error('password')
                                <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs text-gray-400 mb-1">Повторите пароль</label>
                                <input type="password"
                                       name="password_confirmation"
                                       required
                                       class="w-full bg-main-light/40 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-violet-500">
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-[#6d5898] hover:bg-[#5825b5] text-white px-5 py-2 rounded-xl text-xs font-semibold cursor-pointer">
                                Обновить пароль
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
