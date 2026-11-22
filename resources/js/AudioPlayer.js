export default class AudioPlayer {
    constructor() {
        this.audio = new Audio();
        this.queue = [];
        this.currentIndex = -1;
        this.isSeeking = false;
        this.isMuted = false;
        this.lastVolume = 1;

        this.initElements();
        this.initEvents();
    }
    initElements() {
        this.titleEl = document.getElementById("player-title");
        this.artistEl = document.getElementById("player-artist");
        this.coverEl = document.getElementById("album-cover");

        this.seekSlider = document.getElementById("player-seek");
        this.currentTimeEl = document.getElementById("player-current");
        this.durationEl = document.getElementById("player-duration");

        this.backBtn = document.getElementById("back-btn");
        this.nextBtn = document.getElementById("next-btn");
        this.toggleBtn = document.getElementById("toggle-btn");

        this.playIcon = document.getElementById("play-btn-img");
        this.pauseIcon = document.getElementById("pause-btn-img");

        this.volumeBtn = document.getElementById("volume-btn");
        this.vol0 = document.getElementById("volume-0-btn-img");
        this.vol1 = document.getElementById("volume-1-btn-img");
        this.vol2 = document.getElementById("volume-2-btn-img");
        this.updateSeekFill(0);
    }
    initEvents() {
        this.toggleBtn?.addEventListener("click", () => this.toggle());

        this.nextBtn?.addEventListener("click", () => this.next());
        this.backBtn?.addEventListener("click", () => this.prev());

        this.volumeBtn?.addEventListener("click", () => this.toggleMute());

        this.audio.addEventListener("timeupdate", () => this.onTimeUpdate());
        this.audio.addEventListener("loadedmetadata", () =>
            this.onLoadedMetadata(),
        );
        this.audio.addEventListener("ended", () => this.next());

        if (this.seekSlider) {
            this.seekSlider.addEventListener("input", () => {
                this.isSeeking = true;
                this.updateSeekFill(this.seekSlider.value);

                if (this.currentTimeEl && this.audio.duration) {
                    const previewTime =
                        (this.seekSlider.value / 100) * this.audio.duration;
                    this.currentTimeEl.textContent =
                        this.formatTime(previewTime);
                }
            });
            this.seekSlider.addEventListener("change", () => {
                if (this.audio.duration) {
                    this.audio.currentTime =
                        (this.seekSlider.value / 100) * this.audio.duration;
                }
                this.isSeeking = false;
            });
        }
    }
    loadTrack(trackData) {
        if (!trackData?.url) return;
        this.audio.src = trackData.url;
        if (this.titleEl) this.titleEl.textContent = `Трек: ${trackData.title}`;
        if (this.artistEl)
            this.artistEl.textContent = `Автор: ${trackData.author || "Неизвестен"}`;
        if (this.coverEl && trackData.cover) this.coverEl.src = trackData.cover;
        this.play();
        this.seekSlider.value = 0;
        this.updateSeekFill(0);
    }

    play() {
        this.audio
            .play()
            .then(() => this.updatePlayIcon(true))
            .catch((e) =>
                console.warn("Воспроизведение заблокировано браузером:", e),
            );
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
        this.currentIndex = (this.currentIndex + 1) % this.queue.length;
        this.loadTrack(this.queue[this.currentIndex]);
    }

    prev() {
        if (!this.queue.length) return;
        if (this.audio.currentTime > 3) {
            this.audio.currentTime = 0;
            return;
        }
        this.currentIndex =
            (this.currentIndex - 1 + this.queue.length) % this.queue.length;
        this.loadTrack(this.queue[this.currentIndex]);
    }

    toggleMute() {
        if (this.audio.muted) {
            this.audio.muted = false;
            this.setVolumeIcon(this.lastVolume);
        } else {
            this.lastVolume = this.audio.volume;
            this.audio.muted = true;
            this.setVolumeIcon(0);
        }
    }
    setVolumeIcon(val) {
        if (!this.volumeBtn) return;
        // Скрываем все
        this.vol0?.classList.add("hidden");
        this.vol1?.classList.add("hidden");
        this.vol2?.classList.add("hidden");
        // Показываем нужную иконку
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

    onTimeUpdate() {
        if (!this.audio.duration) return;
        const percent = (this.audio.currentTime / this.audio.duration) * 100;
        if (!this.isSeeking && this.seekSlider) {
            this.seekSlider.value = percent;
            this.updateSeekFill(percent);
        }
        if (this.currentTimeEl) {
            this.currentTimeEl.textContent = this.formatTime(
                this.audio.currentTime,
            );
        }
    }

    onLoadedMetadata() {
        if (this.durationEl) {
            this.durationEl.textContent = this.formatTime(this.audio.duration);
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

        const activeColor = "#8b5cf6"; // Фиолетовый (violet-500)
        const inactiveColor = "#374151"; // Темно-серый (gray-700)

        this.seekSlider.style.background = `linear-gradient(to right, ${activeColor} 0%, ${activeColor} ${percent}%, ${inactiveColor} ${percent}%, ${inactiveColor} 100%)`;
    }
}
