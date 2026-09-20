@extends('layouts.app')

@section('title', 'Форма регистрации')

@section('content')
<div class="form-register grid place-items-center h-screen">
    <form class='flex flex-col gap-5' method="post" action="{{ url('/register') }}">
        @csrf
        
        <div class="flex flex-col gap-1">
            <input class='p-3 rounded-2xl text-black transition-colors bg-sidebar-bg border focus:outline-none focus:ring-2 focus:ring-player-bg focus:border-transparent' type="text" id="nameField" name="name" value="{{ old('name') }}" placeholder="Введите имя" aria-label="Введите имя" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <!-- Поле Почта -->
        <div class="flex flex-col gap-1">
            <input class='p-3 rounded-2xl text-black transition-colors bg-sidebar-bg border focus:outline-none focus:ring-2 focus:ring-player-bg focus:border-transparent' type="email" id="emailField" name="email" value="{{ old('email') }}" placeholder="Введите почту" aria-label="Введите почту" required>
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <!-- Поле Пароль -->
        <div class="flex flex-col gap-1">
            <input class='p-3 rounded-2xl text-black transition-colors bg-sidebar-bg border focus:outline-none focus:ring-2 focus:ring-player-bg focus:border-transparent' type="password" id="passwordField" name="password" placeholder="Введите пароль" aria-label="Введите пароль" required>
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <!-- Подтверждение пароля -->
        <div class="flex flex-col gap-1">
            <input class='p-3 rounded-2xl text-black transition-colors bg-sidebar-bg border focus:outline-none focus:ring-2 focus:ring-player-bg focus:border-transparent' type="password" id="passwordField2" name="password_confirmation" placeholder="Повторите пароль" aria-label="Повторите пароль" required>
        </div>
        
        <!-- Чекбокс соглашения (Изменено имя на agree_terms) -->
        <div class="flex flex-col gap-1">
            <div class="flex gap-1">
                <p class="">Вы согласны с <a class="underline" href="{{ route('agreement') }}">пользовательским соглашением</a>?</p>
                <input type="checkbox" name="agree_terms" id="agree-terms" aria-label="Согласен с пользовательским соглашением" required {{ old('agree_terms') ? 'checked' : '' }}>
            </div>
            @error('agree_terms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex ">
            <p>Есть аккаунт?</p>
            <a class="underline" href="{{ route('login') }}">Авторизуйся.</a>
        </div>
        <div class="flex items-center justify-center">
            <button class="submit-btn p-3 bg-sidebar-bg rounded-2xl duration-500 active:bg-sidebar-active transition-colors" type="submit" id="submitButton" name="submitButton">Отправить</button>
        </div>
    </form>
</div>
@endsection
