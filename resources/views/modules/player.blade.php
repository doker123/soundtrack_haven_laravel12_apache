<div class="fixed bottom-0 left-0 right-0 z-50 h-20  bg-player-bg flex items-center justify-between  w-full gap-4">
    <!-- 1. ЗОНА СЛЕВА (Трек) -->
        <div class="flex items-center gap-3 w-1/4 min-w-50">
            <img class="w-12 h-12 rounded-xl object-cover shrink-0" src="{{asset('images/default-avatar.png')}}" alt="Cover">
            <div class="min-w-0 flex-1">
                <p id="sh-player-title" class="font-bold text-text-muted text-sm truncate" title="Название трека">

                </p>
                <p id="sh-player-title" class="text-xs text-gray-400 truncate mt-0.5" >
                    Автор:
                </p>
            </div>
        </div>
        <!-- 2. ЗОНА ПО ЦЕНТРУ (Управление) -->
        <div class="flex gap-4 items-center justify-center flex-1 max-w-2xl">
            <div class="flex gap-4 items-center justify-center flex-1 max-w-2xl">
                <span id="player-current" class="w-10 text-right tabular-nums shrink-0">00:00</span>
                <input type="range"
                    id="player-seek"
                    value="0"
                    min="0"
                    max="100"
                    step="0.1"
                    class="flex-1 h-1.5 bg-gray-700/80 rounded-lg appearance-none cursor-pointer accent-player-dark focus:outline-none">
                <span id="player-duration" class="w-10 text-left tabular-nums shrink-0 text-gray-500">00:00</span>
            </div>
            <div>
                <button>

                </button>
                <button>

                </button>
                <button>

                </button>
                <button>

                </button>
            </div>
        </div>
        <!-- 3. ЗОНА СПРАВА (Громкость) -->
        <div class="flex items-center justify-end w-1/4 min-w-37,5 gap-2">
            <!-- Сюда пойдет ползунок громкости -->
        </div>
</div>
