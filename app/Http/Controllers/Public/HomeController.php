<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Author;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $latestAlbums = Album::with("author")
            ->published()
            ->latest("release_date")
            ->take(5)
            ->get();

        $popularAuthors = Author::withCount(["albums", "tracks"])
            ->orderByDesc("tracks_count")
            ->take(6)
            ->get();

        $publicPlaylists = Playlist::with("user")
            ->public()
            ->withCount("tracks")
            ->latest()
            ->take(5)
            ->get();

        $featuredTracks = Track::with(["author", "album"])
            ->published()
            ->latest()
            ->take(9)
            ->get();
            
        return view(
            "public.home",
            compact(
                "latestAlbums",
                "popularAuthors",
                "publicPlaylists",
                "featuredTracks",
            ),
        );
    }
}
