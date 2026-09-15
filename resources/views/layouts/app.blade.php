<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SoundtrackHaven')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('img/favicon/favicon.svg') }}">
</head>
<body class="bg-main-bg text-slate-100 antialised font-main">
    
    @yield('content')
    
</body>
</html>