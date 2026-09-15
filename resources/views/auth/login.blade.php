@extends('layouts.app')
@section('title', 'Форма авторизации')
@section('content')
<div class='form-auth grid place-items-center h-screen'>
    <form class='flex flex-col gap-5' method="post" action="{{ url('/login') }}">
        @csrf
        <label for="email"></label>
        <input class='p-3 rounded-2xl text-black transition-colors bg-sidebar-bg border focus:outline-none focus:ring-2 focus:ring-player-bg focus:border-transparent' type="email" id="email-field" name="email" placeholder="Введите почту" aria-label="Введите почту" required>
        <label for="password"></label>
        <input class='p-3 rounded-2xl text-black transition-colors bg-sidebar-bg border focus:outline-none focus:ring-2 focus:ring-player-bg focus:border-transparent' type="password" id="password-field" name="password" placeholder="Введите пароль" aria-label="Введите пароль" required>
        <div class="link-rgister-container flex gap-1">
            <p class=''>Нет аккаунта?</p>
            <a class="link-register underline text-player-dark" href="{{ route('register') }}">Зарегистрируйся</a>
        </div>
        <button class='submit-btn p-3 bg-sidebar-bg rounded-2xl duration-500 active:bg-sidebar-active transition-colors' type="submit" id="submit-button" name="submit-button">Авторизоваться</button>
    </form>
</div>
@endsection
