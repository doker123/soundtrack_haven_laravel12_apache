export default class AudioPlayer {
    constructor() {
        this.audio = new Audio();
        this.queue = [];
        this.currentIndex = -1;
        this.isSeeking = false;
        this.isMuted = false;
        this.lastVolume = 1;
        this.isLooping = false;
        this.isShuffled = false;

        this.fallbackDuration = 0;

        this.initElements();
        this.initEvents();
    }
    initElements() {
        this.playerBar = document.getElementById("audio-player-bar");
        this.titleEl = document.getElementById("player-title");
        this.artistEl = document.getElementById("player-artist");
        this.coverEl = document.getElementById("album-cover");

        this.seekSlider = document.getElementById("player-seek");
        this.currentTimeEl = document.getElementById("player-current");
        this.durationEl = document.getElementById("player-duration");

        this.backBtn = document.getElementById("back-btn");
        this.nextBtn = document.getElementById("next-btn");
        this.toggleBtn = document.getElementById("toggle-btn");
        this.loopBtn = document.getElementById("loop-btn");
        this.shuffleBtn = document.getElementById("shuffle-btn");

        this.playIcon = document.getElementById("play-btn-img");
        this.pauseIcon = document.getElementById("pause-btn-img");

        this.volumeBtn = document.getElementById("volume-btn");
        this.volumeSlider = document.getElementById("player-volume");
        this.vol0 = document.getElementById("volume-0-btn-img");
        this.vol1 = document.getElementById("volume-1-btn-img");
        this.vol2 = document.getElementById("volume-2-btn-img");
        this.updateSeekFill(0);
        this.updateVolumeFill(100);
    }
    initEvents() {
        this.toggleBtn?.addEventListener("click", () => this.toggle());

        this.nextBtn?.addEventListener("click", () => this.next());
        this.backBtn?.addEventListener("click", () => this.prev());
        this.loopBtn?.addEventListener("click", () => this.toggleLoop());
        this.shuffleBtn?.addEventListener("click", () => this.toggleShuffle());

        this.volumeBtn?.addEventListener("click", () => this.toggleMute());

        if (this.volumeSlider) {
            this.volumeSlider.addEventListener("input", (e) => {
                const val = parseFloat(e.target.value);
                this.audio.volume = val;
                this.audio.muted = val === 0;
                this.lastVolume = val > 0 ? val : this.lastVolume;
                this.setVolumeIcon(val);
                this.updateVolumeFill(val * 100);
            });
        }

        this.audio.addEventListener("timeupdate", () => this.onTimeUpdate());
        this.audio.addEventListener("loadedmetadata", () => this.onLoadedMetadata());
        this.audio.addEventListener("ended", () => this.next());
        this.audio.addEventListener("error", () => {

        });

        if (this.seekSlider) {
            this.seekSlider.addEventListener("input", () => {
                this.isSeeking = true;
                this.updateSeekFill(this.seekSlider.value);

                const duration = this.getDuration();
                if (this.currentTimeEl && duration > 0) {
                    const previewTime = (this.seekSlider.value / 100) * duration;
                    this.currentTimeEl.textContent = this.formatTime(previewTime);
                }
            });
            this.seekSlider.addEventListener("change", () => {
                const duration = this.getDuration();
                if (duration > 0) {
                    this.audio.currentTime = (this.seekSlider.value / 100) * duration;
                }
                this.isSeeking = false;
            });
        }
    }
    loadTrack(trackData) {
        this.audio.pause();
        this.audio.currentTime = 0;
        this.audio.src = '';

        this.show();
        this.fallbackDuration = Number(trackData.duration) || 0;
        this.audio.src = trackData.url;
        this.audio.load();

        if (this.titleEl) this.titleEl.textContent = `Трек: ${trackData.title}`;
        if (this.artistEl) this.artistEl.textContent = `Автор: ${trackData.author || "Неизвестен"}`;
        if (this.coverEl && trackData.cover) this.coverEl.src = trackData.cover;
        if (this.durationEl && this.fallbackDuration > 0) {
            this.durationEl.textContent = this.formatTime(this.fallbackDuration);
        }

        if (this.seekSlider) {
            this.seekSlider.value = 0;
            this.updateSeekFill(0);
        }

        const tryPlay = () => {
            this.play();
            this.audio.removeEventListener('canplay', tryPlay);
        };
        this.audio.addEventListener('canplay', tryPlay);
        this.play();
    }
    show() {
        if (this.playerBar && this.playerBar.classList.contains("hidden")) {
            this.playerBar.classList.remove("hidden");
        }
    }
    play() {
        this.audio
            .play()
            .then(() => {
                this.updatePlayIcon(true);
            })
            .catch((e) => {
                // Optional: handle playback errors silently
            });
    }

    pause() {
        this.audio.pause();
        this.updatePlayIcon(false);
    }
    toggle() {
        if (!this.audio.src) return;
        this.audio.paused ? this.play() : this.pause();
    }
    next() {
        if (!this.queue.length) return;
        if (this.isLooping) {
            this.audio.currentTime = 0;
            return;
        }
        if (this.isShuffled && this.queue.length > 1) {
            let randomIndex;
            do {
                randomIndex = Math.floor(Math.random() * this.queue.length);
            } while (randomIndex === this.currentIndex);
            this.currentIndex = randomIndex;
        } else {
            this.currentIndex = (this.currentIndex + 1) % this.queue.length;
        }
        this.loadTrack(this.queue[this.currentIndex]);
    }
    toggleLoop() {
        this.isLooping = !this.isLooping;
        this.audio.loop = this.isLooping;
        const img = this.loopBtn?.querySelector("img");
        if (this.isLooping) {
            this.loopBtn?.classList.add("text-violet-400");
            this.loopBtn?.classList.remove("text-gray-500");
            img?.classList.remove("opacity-40");
            img?.classList.add("opacity-100", "brightness-125");
            this.nextBtn?.classList.add("opacity-25", "cursor-not-allowed");
            this.backBtn?.classList.add("opacity-25", "cursor-not-allowed");
        } else {
            this.loopBtn?.classList.remove("text-violet-400");
            this.loopBtn?.classList.add("text-gray-500");
            img?.classList.add("opacity-40");
            img?.classList.remove("opacity-100", "brightness-125");
            this.nextBtn?.classList.remove("opacity-25", "cursor-not-allowed");
            this.backBtn?.classList.remove("opacity-25", "cursor-not-allowed");
        }
    }
    toggleShuffle() {
        this.isShuffled = !this.isShuffled;
        const img = this.shuffleBtn?.querySelector("img");
        if (this.isShuffled) {
            this.shuffleBtn?.classList.add("text-violet-400");
            this.shuffleBtn?.classList.remove("text-gray-500");
            img?.classList.remove("opacity-40");
            img?.classList.add("opacity-100", "brightness-125");
        } else {
            this.shuffleBtn?.classList.remove("text-violet-400");
            this.shuffleBtn?.classList.add("text-gray-500");
            img?.classList.add("opacity-40");
            img?.classList.remove("opacity-100", "brightness-125");
        }
    }
    prev() {
        if (!this.queue.length) return;
        if (this.isLooping || this.audio.currentTime > 3) {
            this.audio.currentTime = 0;
            return;
        }
        this.currentIndex = (this.currentIndex - 1 + this.queue.length) % this.queue.length;
        this.loadTrack(this.queue[this.currentIndex]);
    }
    toggleMute() {
        if (this.audio.muted || this.audio.volume === 0) {
            const restoredVolume = this.lastVolume > 0 ? this.lastVolume : 1;
            this.audio.muted = false;
            this.audio.volume = restoredVolume;
            if (this.volumeSlider) this.volumeSlider.value = restoredVolume;
            this.setVolumeIcon(restoredVolume);
            this.updateVolumeFill(restoredVolume * 100);
        } else {
            this.lastVolume = this.audio.volume;
            this.audio.muted = true;
            this.audio.volume = 0;
            if (this.volumeSlider) this.volumeSlider.value = 0;
            this.setVolumeIcon(0);
            this.updateVolumeFill(0);
        }
    }
    updateVolumeFill(percent) {
        if (!this.volumeSlider) return;
        const val = Number(percent);
        const activeColor = "#8b5cf6"; // violet-500
        const inactiveColor = "#374151"; // gray-700
        this.volumeSlider.style.background = `linear-gradient(to right, ${activeColor} 0%, ${activeColor} ${val}%, ${inactiveColor} ${val}%, ${inactiveColor} 100%)`;
    }
    setVolumeIcon(val) {
        if (!this.volumeBtn) return;
        this.vol0?.classList.add("hidden");
        this.vol1?.classList.add("hidden");
        this.vol2?.classList.add("hidden");
        if (val === 0 || this.audio.muted) {
            this.vol0?.classList.remove("hidden");
        } else if (val < 0.5) {
            this.vol1?.classList.remove("hidden");
        } else {
            this.vol2?.classList.remove("hidden");
        }
    }
    updatePlayIcon(isPlaying) {
        if (!this.playIcon || !this.pauseIcon) return;
        if (isPlaying) {
            this.playIcon.classList.add("hidden");
            this.pauseIcon.classList.remove("hidden");
        } else {
            this.playIcon.classList.remove("hidden");
            this.pauseIcon.classList.add("hidden");
        }
    }
    getDuration() {
        if (this.audio.duration && !isNaN(this.audio.duration) && isFinite(this.audio.duration)) {
            return this.audio.duration;
        }
        return this.fallbackDuration || 0;
    }
    onTimeUpdate() {
        const duration = this.getDuration();
        if (this.currentTimeEl) {
            this.currentTimeEl.textContent = this.formatTime(this.audio.currentTime);
        }
        if (duration > 0 && !this.isSeeking && this.seekSlider) {
            const percent = (this.audio.currentTime / duration) * 100;
            this.seekSlider.value = Math.min(100, Math.max(0, percent));
            this.updateSeekFill(this.seekSlider.value);
        }
    }
    onLoadedMetadata() {
        const duration = this.getDuration();
        if (this.durationEl && duration > 0) {
            this.durationEl.textContent = this.formatTime(duration);
        }
    }
    formatTime(seconds) {
        if (isNaN(seconds)) return "00:00";
        const min = Math.floor(seconds / 60);
        const sec = Math.floor(seconds % 60);
        return `${String(min).padStart(2, "0")}:${String(sec).padStart(2, "0")}`;
    }
    updateSeekFill(percent) {
        if (!this.seekSlider) return;
        const activeColor = "#8b5cf6";
        const inactiveColor = "#374151";
        this.seekSlider.style.background = `linear-gradient(to right, ${activeColor} 0%, ${activeColor} ${percent}%, ${inactiveColor} ${percent}%, ${inactiveColor} 100%)`;
    }
}
