<div class="fixed bottom-0 left-0 right-0 z-50 h-20  bg-player-bg flex items-center justify-around  w-full gap-4">
    <!-- 1. ЗОНА СЛЕВА (Трек) -->
        <div class="flex items-center gap-3 w-1/4 min-w-50">
            <img id="album-cover" class="w-12 h-12 rounded-xl object-cover shrink-0" src="{{asset('images/default-avatar.svg')}}" alt="Cover">
            <div class="min-w-0 flex-1 flex-col gap-4 ">
                <p id="player-title" class="font-bold text-text-muted text-sm truncate" title="Название трека">

                </p>
                <p id="player-artist" class="text-xs text-gray-400 truncate mt-0.5" >

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
                <div>
                    <span id="player-current" class="w-10 text-right tabular-nums shrink-0">00:00</span>
                    <span>/</span>
                    <span id="player-duration" class="w-10 text-right tabular-nums shrink-0">10:00</span>
                </div>
            </div>
            <div class="flex gap-4 items-center">
                <button id="back-btn">
                    <img class="w-10 h-10" src="{{asset('images/player_buttons/back.svg')}}" alt="arrow_back">
                </button>
                <button id="toggle-btn">
                    <img id="play-btn-img" class="hidden w-10 h-10" src="{{asset('images/player_buttons/play.svg')}}" alt="play">
                    <img id="pause-btn-img" class="w-10 h-10" src="{{asset('images/player_buttons/pause.svg')}}" alt="pause">
                </button>
                <button id="next-btn">
                    <img class="w-10 h-10" src="{{asset('images/player_buttons/forward.svg')}}" alt="arrow_forward">
                </button>
            </div>
        </div>
        <!-- 3. ЗОНА СПРАВА (Громкость) -->
        <div class="flex items-center justify-end w-1/4 min-w-37,5 gap-2 ml-4">
            <button id="volume-btn">
                <img id="volume-0-btn-img" class="hidden" src="{{asset('images/player_buttons/volume0.svg')}}" alt="volume">
                <img id="volume-1-btn-img" class="" src="{{asset('images/player_buttons/volume1.svg')}}" alt="volume">
                <img id="volume-2-btn-img" class="hidden" src="{{asset('images/player_buttons/volume2.svg')}}" alt="volume">
            </button>
        </div>
</div>
