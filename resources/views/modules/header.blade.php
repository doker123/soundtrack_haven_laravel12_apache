<header class="w-full bg-sidebar-bg px-6 py-4 flex items-center justify-between border-b border-gray-800 text-white font-medium select-none shadow-md">

    {{-- Логотип --}}
    <div class="shrink-0">
        <a href="/" class="block text-5xl text-[#F5F5F7] hover:text-[#6d5898] active:text-[#5825b5] transition-colors tracking-wider">
            SH
        </a>
    </div>

    {{-- Горизонтальная навигация --}}
    <nav class="flex items-center gap-8 relative text-base">

        {{-- Админское выпадающее меню (Буквенная кнопка) --}}
        @can('admin')
        <div class="relative">
            <button id="adminDropdownBtn" type="button" class="flex items-center gap-1 hover:text-[#6d5898] active:text-[#5825b5] transition-colors focus:outline-none uppercase tracking-wider font-semibold text-red-400 select-none">
                <span>Админ</span>
                {{-- Стрелочка теперь указывает вниз --}}
                <svg id="adminDropdownArrow" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            {{-- Всплывающий список (Открывается ВНИЗ: left-0 mt-2) --}}
            <div id="adminDropdownMenu" class="absolute left-0 mt-2 w-48 bg-sidebar-bg border border-gray-700 rounded-2xl shadow-xl z-50 p-2 flex-col gap-1 hidden">
                <a href="#" class="p-2.5 rounded-xl hover:bg-sidebar-hover transition-colors text-sm block text-left">Пользователи</a>
                <a href="#" class="p-2.5 rounded-xl hover:bg-sidebar-hover transition-colors text-sm block text-left">Настройки сайта</a>
            </div>
        </div>
        @endcan

        {{-- Текстовые ссылки для авторизованных --}}
        @auth
        <a href="#" class="hover:text-[#6d5898] active:text-[#5825b5] transition-colors uppercase tracking-wider">
            Избранное
        </a>
        <a href="#" class="hover:text-[#6d5898] active:text-[#5825b5] transition-colors uppercase tracking-wider">
            Поиск
        </a>
        <a href="#" class="hover:text-[#6d5898] active:text-[#5825b5] transition-colors uppercase tracking-wider">
            Опции
        </a>
        @endauth

        {{-- Ссылка входа для гостей --}}

    </nav>

    {{-- Профиль и Выход (В правом углу) --}}
    <div class="shrink-0 flex items-center gap-4">
        @auth
            <a href="#" class="hover:underline text-sm tracking-wide block max-w-30 truncate">
                {{ Auth::user()->name }}
            </a>

            <form action="#" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-xs text-red-400 hover:text-red-500 underline transition-colors cursor-pointer">
                    Выйти
                </button>
            </form>
        @else
            <a href="#" class="text-sm hover:underline tracking-wide block">
                Войти
            </a>
            <a href="#" class="text-sm hover:underline tracking-wide block">
                Регистрация
            </a>
            <a href="#" class="text-sm text-red-500 hover:underline tracking-wide block">
                Админ
            </a>
        @endif
    </div>
</header>
