<footer class="bg-sidebar-bg border-t border-gray-800/80 text-slate-200 text-sm mt-auto pb-28 pt-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}" class="text-3xl font-extrabold text-white hover:text-violet-500 transition-colors tracking-wider">
                    Soundtrack<span class="text-violet-500">Haven</span>
                </a>
                <p class="text-xs text-white leading-relaxed">
                    Архив оригинальных игровых саундтреков. Слушайте легендарные композиции и собирайте собственные коллекции.
                </p>
            </div>
            <div class="flex flex-col gap-3">
                <h4 class="text-xs font-semibold text-white uppercase tracking-wider">Каталог</h4>
                <ul class="flex flex-col gap-2 text-xs">
                    <li><a href="{{ route('home') }}" class="text-white hover:text-violet-400 transition-colors">Главная страница</a></li>
                    <li><a href="{{ route('search') }}" class="text-white hover:text-violet-400 transition-colors">Поиск музыки</a></li>
                    <li><a href="{{ route('home') }}#featured-tracks" class="text-white hover:text-violet-400 transition-colors">Популярные треки</a></li>
                </ul>
            </div>
            <div class="flex flex-col gap-3">
                <h4 class="text-xs font-semibold text-white uppercase tracking-wider">Моя медиатека</h4>
                <ul class="flex flex-col gap-2 text-xs">
                    @auth
                        <li><a href="{{ route('public.playlists.index') }}" class="text-white hover:text-violet-400 transition-colors">Мои плейлисты</a></li>
                        <li><a href="{{ route('public.favorites.index') }}" class="text-white hover:text-violet-400 transition-colors">Любимые треки</a></li>
                        <li><a href="{{ route('public.history.index') }}" class="text-white hover:text-violet-400 transition-colors">История прослушиваний</a></li>
                        <li><a href="{{ route('public.settings.edit') }}" class="text-white hover:text-violet-400 transition-colors">Настройки профиля</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-white hover:text-violet-400 transition-colors">Войти в аккаунт</a></li>
                        <li><a href="{{ route('register') }}" class="text-white hover:text-violet-400 transition-colors">Регистрация</a></li>
                    @endauth
                </ul>
            </div>
            <div class="flex flex-col gap-3">
                <h4 class="text-xs font-semibold text-white uppercase tracking-wider">Информация</h4>
                <ul class="flex flex-col gap-2 text-xs">
                    <li><a href="{{ route('agreement') }}" class="text-white hover:text-violet-400 transition-colors">Пользовательское соглашение</a></li>
                    <li><span class="text-white text-[11px] leading-relaxed">Все аудиоматериалы представлены в ознакомительных целях. Права принадлежат разработчикам и композиторам.</span></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800/80 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white">
            <span>© {{ date('Y') }} Soundtrack Haven. Некоммерческий игровой проект.</span>
            <span>Сделано с любовью к игровой музыке</span>
        </div>
    </div>
</footer>
