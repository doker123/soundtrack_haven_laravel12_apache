import "./bootstrap";
import "./dropdown";
import AudioPlayer from "./AudioPlayer";

document.addEventListener("DOMContentLoaded", () => {
    const player = new AudioPlayer();

    // 1. Обычный клик по конкретному треку
    document.addEventListener("click", (e) => {
        const trackBtn = e.target.closest("[data-track-url]");
        if (!trackBtn) return;



        // Собираем все треки страницы в очередь
        const allTrackEls = Array.from(
            document.querySelectorAll("[data-track-url]"),
        );
        player.queue = allTrackEls.map((el) => ({
            id: el.dataset.trackId,
            title: el.dataset.trackTitle,
            author: el.dataset.trackAuthor,
            cover: el.dataset.trackCover,
            duration: el.dataset.trackDuration,
            url: el.dataset.trackUrl,
        }));

        player.currentIndex = allTrackEls.indexOf(trackBtn);


        if (player.currentIndex !== -1) {
            player.loadTrack(player.queue[player.currentIndex]);
        }
    });

    // 2. Кнопка «Слушать весь альбом»
    const playAlbumBtn = document.getElementById("play-album-btn");
    if (playAlbumBtn) {
        playAlbumBtn.addEventListener("click", () => {
            // Находим все треки альбома на странице
            const trackEls = Array.from(
                document.querySelectorAll("[data-track-url]"),
            );

            if (trackEls.length === 0) {
                alert("В этом альбоме пока нет треков для воспроизведения");
                return;
            }

            player.queue = trackEls.map((el) => ({
                id: el.dataset.trackId,
                title: el.dataset.trackTitle,
                author: el.dataset.trackAuthor,
                cover: el.dataset.trackCover,
                duration: el.dataset.trackDuration,
                url: el.dataset.trackUrl,
            }));

            player.currentIndex = 0;
            player.loadTrack(player.queue[0]);
        });
    }

    const playAuthorBtn = document.getElementById('play-all-author-tracks');
    if (playAuthorBtn) {
        playAuthorBtn.addEventListener('click', () => {
            const trackEls = Array.from(document.querySelectorAll('[data-track-url]'));
            if (!trackEls.length) return;
            player.queue = trackEls.map(el => ({
                id: el.dataset.trackId,
                title: el.dataset.trackTitle,
                author: el.dataset.trackAuthor,
                cover: el.dataset.trackCover,
                duration: el.dataset.trackDuration,
                url: el.dataset.trackUrl,
            }));
            player.currentIndex = 0;
            player.loadTrack(player.queue[0]);
        });
    }
});