@extends('layouts.app')
@section('title', 'Пользовательское соглашение — Soundtrack Haven')
@section('content')
<div class="max-w-4xl mx-auto px-6 py-12 flex flex-col gap-10">
    <div class="border-b border-gray-800 pb-8 flex flex-col gap-3">
        <div class="inline-flex items-center gap-2 text-xs font-semibold text-violet-400 uppercase tracking-widest bg-violet-950/40 border border-violet-500/20 px-3 py-1 rounded-full w-fit">
            Юридическая информация
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Пользовательское соглашение
        </h1>
        <p class="text-sm text-gray-400">
            Редакция действует с момента публикации. Пожалуйста, внимательно ознакомьтесь с условиями использования платформы Soundtrack Haven.
        </p>
    </div>
    <div class="flex flex-col gap-6">
        <section class="bg-main-dark border border-gray-800 rounded-2xl p-6 sm:p-7 flex flex-col gap-4 shadow-lg">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-violet-950/60 border border-violet-500/30 text-violet-400 text-sm font-bold flex items-center justify-center shrink-0">
                    1
                </span>
                <h2 class="text-lg font-bold text-white">Общие положения</h2>
            </div>
            <ul class="text-sm text-gray-300 leading-relaxed space-y-2.5 list-disc list-inside marker:text-violet-500">
                <li>Используя данный Сайт, Пользователь выражает полное и безоговорочное согласие с условиями настоящего Соглашения.</li>
                <li>Настоящее Соглашение может быть изменено администрацией Сайта без предварительного уведомления. Новая редакция Соглашения вступает в силу с момента её публикации на Сайте, если иное не предусмотрено новой редакцией.</li>
                <li>Пользователь несёт ответственность за соблюдение положений настоящего Соглашения, а также применимого законодательства своей страны.</li>
            </ul>
        </section>
        <section class="bg-main-dark border border-gray-800 rounded-2xl p-6 sm:p-7 flex flex-col gap-4 shadow-lg">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-violet-950/60 border border-violet-500/30 text-violet-400 text-sm font-bold flex items-center justify-center shrink-0">
                    2
                </span>
                <h2 class="text-lg font-bold text-white">Описание сервиса</h2>
            </div>
            <ul class="text-sm text-gray-300 leading-relaxed space-y-2.5 list-disc list-inside marker:text-violet-500">
                <li>Сайт Soundtrack Haven предоставляет доступ к каталогу саундтреков видеоигр, информации о композиторах, альбомах и контексте использования музыки.</li>
                <li>Сайт предоставляет возможность прослушивания композиций в ознакомительных целях, а также создания пользовательских плейлистов и списков избранного.</li>
                <li>Базовый доступ к возможностям Сайта предоставляется на безвозмездной основе.</li>
            </ul>
        </section>
        <section class="bg-main-dark border border-gray-800 rounded-2xl p-6 sm:p-7 flex flex-col gap-4 shadow-lg">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-violet-950/60 border border-violet-500/30 text-violet-400 text-sm font-bold flex items-center justify-center shrink-0">
                    3
                </span>
                <h2 class="text-lg font-bold text-white">Права и обязанности Пользователя</h2>
            </div>
            <p class="text-sm text-gray-300">
                Пользователь обязуется использовать Сайт исключительно в законных целях и не нарушать права третьих лиц.
            </p>
            <div class="bg-gray-900/60 border border-gray-800 rounded-xl p-4 flex flex-col gap-2">
                <span class="text-xs font-semibold text-rose-400 uppercase tracking-wider">Категорически запрещено:</span>
                <ul class="text-xs sm:text-sm text-gray-400 space-y-1.5 list-disc list-inside marker:text-rose-500">
                    <li>Использовать автоматизированные скрипты, парсеры и боты для сбора данных без письменного разрешения администрации.</li>
                    <li>Предпринимать попытки обхода защиты, вмешательства в работу серверной инфраструктуры и API Сайта.</li>
                    <li>Публиковать или передавать вредоносный, оскорбительный, клеветнический или противоправный контент.</li>
                    <li>Использовать материалы и функции Сайта в коммерческих целях без согласования с правообладателями.</li>
                </ul>
            </div>
            <p class="text-xs text-gray-400">
                Пользователь несёт личную ответственность за сохранность данных своей учетной записи и любые действия, совершенные под его аккаунтом.
            </p>
        </section>
        <section class="bg-main-dark border border-gray-800 rounded-2xl p-6 sm:p-7 flex flex-col gap-4 shadow-lg">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-violet-950/60 border border-violet-500/30 text-violet-400 text-sm font-bold flex items-center justify-center shrink-0">
                    4
                </span>
                <h2 class="text-lg font-bold text-white">Права администрации</h2>
            </div>
            <ul class="text-sm text-gray-300 leading-relaxed space-y-2.5 list-disc list-inside marker:text-violet-500">
                <li>Администрация имеет право в любое время изменять структуру, оформление и функционал Сайта без предварительного предупреждения.</li>
                <li>Администрация оставляет за собой право блокировать аккаунты пользователей, нарушающих условия настоящего Соглашения, а также удалять неприемлемый контент.</li>
                <li>Администрация вправе вводить технические перерывы для проведения регламентных и профилактических работ.</li>
            </ul>
        </section>
        <section class="bg-main-dark border border-gray-800 rounded-2xl p-6 sm:p-7 flex flex-col gap-4 shadow-lg">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-violet-950/60 border border-violet-500/30 text-violet-400 text-sm font-bold flex items-center justify-center shrink-0">
                    5
                </span>
                <h2 class="text-lg font-bold text-white">Интеллектуальная собственность</h2>
            </div>
            <ul class="text-sm text-gray-300 leading-relaxed space-y-2.5 list-disc list-inside marker:text-violet-500">
                <li>Все музыкальные произведения, названия игр, логотипы, торговые марки и графические материалы принадлежат их законным авторам и правообладателям.</li>
                <li>Материалы представлены на Сайте исключительно для частного домашнего прослушивания и ознакомления.</li>
                <li>Дизайн, программный код и элементы структуры интерфейса Soundtrack Haven охраняются авторским правом.</li>
            </ul>
        </section>
        <section class="bg-main-dark border border-gray-800 rounded-2xl p-6 sm:p-7 flex flex-col gap-4 shadow-lg">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-violet-950/60 border border-violet-500/30 text-violet-400 text-sm font-bold flex items-center justify-center shrink-0">
                    6
                </span>
                <h2 class="text-lg font-bold text-white">Ограничение ответственности</h2>
            </div>
            <ul class="text-sm text-gray-300 leading-relaxed space-y-2.5 list-disc list-inside marker:text-violet-500">
                <li>Сервис предоставляется по принципу «как есть» (as is). Администрация не гарантирует бесперебойную и безошибочную работу всех служб.</li>
                <li>Администрация не несёт ответственности за возможные перебои в доступе, потерю пользовательских настроек или сторонние ссылки.</li>
            </ul>
        </section>
        <section class="bg-main-dark border border-gray-800 rounded-2xl p-6 sm:p-7 flex flex-col gap-4 shadow-lg">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-violet-950/60 border border-violet-500/30 text-violet-400 text-sm font-bold flex items-center justify-center shrink-0">
                    7
                </span>
                <h2 class="text-lg font-bold text-white">Заключительные положения</h2>
            </div>
            <ul class="text-sm text-gray-300 leading-relaxed space-y-2.5 list-disc list-inside marker:text-violet-500">
                <li>Настоящее Соглашение вступает в силу с момента первого посещения или использования любого сервиса Сайта Пользователем.</li>
                <li>Признание отдельных пунктов настоящего документа недействительными не отменяет действие остальных его положений.</li>
            </ul>
        </section>
    </div>
    <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500 border-t border-gray-800/80">
        <span>© {{ date('Y') }} Soundtrack Haven. Все права защищены.</span>
        <a href="{{ route('home') }}" class="text-violet-400 hover:text-violet-300 font-semibold transition-colors flex items-center gap-1">
            <span>← Вернуться на главную</span>
        </a>
    </div>
</div>
@endsection
