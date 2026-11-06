<header class="w-full bg-sidebar-bg px-6 py-4 flex items-center justify-between border-b border-gray-800 text-white font-medium select-none shadow-md">


    <div class="shrink-0">
        <a href="/" class="block text-5xl text-[#F5F5F7] hover:text-[#6d5898] active:text-[#5825b5] transition-colors tracking-wider">
            SH
        </a>
    </div>

    <nav class="flex items-center gap-8 relative text-base">

        @can('admin')
            <div class="relative">

                <button id="admin-btn" type="button" class="flex items-center gap-1 hover:text-[#6d5898] active:text-[#5825b5] transition-colors focus:outline-none uppercase tracking-wider font-semibold text-red-400 select-none">
                    <span>Админ</span>

                    <svg class="dropdown-arrow w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="admin-menu" class="dropdown-menu absolute left-0 mt-2 w-48 bg-sidebar-bg border border-none rounded-2xl shadow-xl z-50 p-2 flex-col gap-1 hidden">
                    <a href="{{route('admin.authors.index')}}" class="p-2.5 rounded-xl hover:bg-sidebar-hover transition-colors text-sm block text-left">Авторы</a>
                    <a href="{{route('admin.tracks.index')}}" class="p-2.5 rounded-xl hover:bg-sidebar-hover transition-colors text-sm block text-left">Треки</a>
                    <a href="{{route('admin.albums.index')}}" class="p-2.5 rounded-xl hover:bg-sidebar-hover transition-colors text-sm block text-left">Альбомы</a>
                    <a href="{{route('admin.users.index')}}" class="p-2.5 rounded-xl hover:bg-sidebar-hover transition-colors text-sm block text-left">Пользаватели</a>
                </div>
            </div>
        @endcan

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
    </nav>

    {{-- Профиль и Выход (В правом углу) --}}
    <div class="shrink-0 flex items-center gap-4">
        @auth
            <a href="#" class="hover:underline text-sm tracking-wide block max-w-30 truncate">
                {{ Auth::user()->name }}
            </a>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-xs text-red-400 hover:text-red-500 underline transition-colors cursor-pointer">
                    Выйти
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-sm hover:underline tracking-wide block">
                Войти
            </a>
            <a href="{{ route('register') }}" class="text-sm hover:underline tracking-wide block">
                Регистрация
            </a>
        @endif
    </div>
</header>
