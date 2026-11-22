<div id="audio-player-bar" class="hidden fixed bottom-0 left-0 right-0 z-50 h-20 bg-player-bg flex items-center justify-around w-full gap-4 shadow-2xl border-t border-gray-800/80 transition-all duration-300">
    <!-- 1. ЗОНА СЛЕВА (Трек) -->
        <div class="flex items-center gap-3 w-1/4 min-w-50">
            <img id="album-cover" class="w-12 h-12 rounded-xl object-cover shrink-0" src="{{asset('images/default-avatar.svg')}}" alt="Cover">
            <div class="min-w-0 flex-1 flex-col gap-4 ">
                <p id="player-title" class="font-bold text-white text-sm truncate" title="Название трека">

                </p>
                <p id="player-artist" class="text-xs text-gray-200 truncate mt-0.5" >

                </p>
            </div>
        </div>
        <!-- 2. ЗОНА ПО ЦЕНТРУ (Управление) -->
        <div class="flex gap-4 flex-col items-center justify-center flex-1 w-full">
            <div class="flex gap-4 items-center justify-center flex-1 w-full">
                <input type="range"
                    id="player-seek"
                    value="0"
                    min="0"
                    max="100"
                    step="0.1"
                    class="flex-1 h-1.5 rounded-lg appearance-none cursor-pointer accent-violet-500 focus:outline-none">
                <div class="flex items-center gap-1.5 text-xs text-white">
                    <span id="player-current" class="w-10 text-right tabular-nums shrink-0 font-medium text-white">00:00</span>
                    <span class="text-gray-400">/</span>
                    <span id="player-duration" class="w-10 text-left tabular-nums shrink-0 text-gray-300">00:00</span>
                </div>
            </div>
            <div class="flex gap-4 items-center">
                <button id="shuffle-btn" type="button" class="p-1 text-gray-500 hover:text-white transition duration-200 cursor-pointer" title="Случайный порядок">
                    <img class="w-6 h-6 opacity-40 hover:opacity-100 transition-opacity pointer-events-none" src="{{asset('images/player_buttons/random.svg')}}" alt="shuffle">
                </button>
                <button id="back-btn" type="button" class="cursor-pointer">
                    <img class="w-9 h-9 pointer-events-none" src="{{asset('images/player_buttons/back.svg')}}" alt="arrow_back">
                </button>
                <button id="toggle-btn" type="button" class="cursor-pointer">
                    <img id="play-btn-img" class="hidden w-10 h-10 pointer-events-none" src="{{asset('images/player_buttons/play.svg')}}" alt="play">
                    <img id="pause-btn-img" class="w-10 h-10 pointer-events-none" src="{{asset('images/player_buttons/pause.svg')}}" alt="pause">
                </button>
                <button id="next-btn" type="button" class="cursor-pointer">
                    <img class="w-9 h-9 pointer-events-none" src="{{asset('images/player_buttons/forward.svg')}}" alt="arrow_forward">
                </button>
                <button id="loop-btn" type="button" class="p-1 text-gray-500 hover:text-white transition duration-200 cursor-pointer" title="Зациклить трек">
                    <img class="w-6 h-6 opacity-40 hover:opacity-100 transition-opacity pointer-events-none" src="{{asset('images/player_buttons/refresh.svg')}}" alt="loop">
                </button>
            </div>
        </div>
        <!-- 3. ЗОНА СПРАВА (Громкость) -->
        <div class="flex items-center justify-end w-1/4 min-w-[160px] gap-2.5 mr-6">
            <button id="volume-btn" type="button" class="cursor-pointer p-1 text-gray-400 hover:text-white transition" title="Звук">
                <img id="volume-0-btn-img" class="hidden w-5 h-5 pointer-events-none" src="{{asset('images/player_buttons/volume0.svg')}}" alt="mute">
                <img id="volume-1-btn-img" class="hidden w-5 h-5 pointer-events-none" src="{{asset('images/player_buttons/volume1.svg')}}" alt="low volume">
                <img id="volume-2-btn-img" class="w-5 h-5 pointer-events-none" src="{{asset('images/player_buttons/volume2.svg')}}" alt="high volume">
            </button>
            <input type="range"
                   id="player-volume"
                   value="1"
                   min="0"
                   max="1"
                   step="0.01"
                   class="w-24 h-1.5 rounded-lg appearance-none cursor-pointer accent-violet-500 focus:outline-none">
        </div>
</div>
