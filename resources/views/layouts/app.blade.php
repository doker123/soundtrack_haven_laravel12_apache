<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Soundtrack-Haven')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/favicon/favicon.svg') }}">
</head>
<body class="bg-main-bg text-slate-100 antialised font-main flex flex-col">
    @include('modules.header')
    <div class="flex-1 flex flex-col">
        <main class="flex-1">
            @yield('content')
        </main>
        @include('modules.footer')
    </div>
    @include('modules.player')
</body>
</html>
