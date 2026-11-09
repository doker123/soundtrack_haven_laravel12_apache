<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Public\StorePlaylistRequest;
use App\Http\Requests\Public\UpdatePlaylistRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $playlists = $request
            ->user()
            ->playlists()
            ->withCount("tracks")
            ->paginate(12);
        return view("public.playlists.index", compact("playlists"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("public.playlists.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlaylistRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $coverPath = null;
        if ($request->hasFile("cover")) {
            $coverPath = $request
                ->file("cover")
                ->store("covers/playlists", "public");
        }
        $playlist = $request
            ->user()
            ->playlists()
            ->create([
                "title" => $data["title"],
                "description" => $data["description"] ?? null,
                "cover_path" => $coverPath,
                "is_public" => $data["is_public"] ?? false,
            ]);

        return redirect()
            ->route("pblic.playlists.show", $playlist)
            ->with("success", "Плейлист создан!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist): View
    {
        $this->authorize("view", $playlist);
        $playlist->load(["user", "tracks.author", "tracks.album"]);
        return view("public.playlists.show", compact("playlist"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist): View
    {
        $this->authorize("update", $playlist);
        return view("public.playlists.edit", compact("playlist"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlaylistRequest $request, Playlist $playlist)
    {
        $this->authorize("update", $playlist);

        $data = $request->validated();

        if ($request->hasFile("cover")) {
            if (
                $playlist->cover_path &&
                Storage::disk("public")->exists($playlist->cover_path)
            ) {
                Storage::disk("public")->delete($playlist->cover_path);
            }
            $playlist->cover_path = $request
                ->file("cover")
                ->store("covers/playlists", "public");
        }
        $playlist->title = $data["title"];
        $playlist->description = $data["description"] ?? null;
        $playlist->is_public = $request->boolean("is_public");
        $playlist->save();

        return redirect()
            ->route("public.playlists.show", $playlist)
            ->with("success", "Плейлист обновлен!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        $this->authorize("delete", $playlist);
        if (
            $playlist->cover_path &&
            Storage::disk("public")->exists($playlist->cover_path)
        ) {
            Storage::disk("public")->delete($playlist->cover_path);
        }
        $playlist->delete();
        return redirect()
            ->route("public.playlists.index")
            ->with("success", "Плейлист удален.");
    }

    public function addTrack(
        Request $request,
        Playlist $playlist,
    ): RedirectResponse {
        $this->authorize("update", $playlist);
        $validated = $request->validate([
            "track_id" => ["required", "exists:tracks,id"],
        ]);
        if (
            !$playlist
                ->tracks()
                ->where("track_id", $validated["track_id"])
                ->exists()
        ) {
            $nextPosition = ($playlist->tracks()->max("position") ?? 0) + 1;
            $playlist
                ->tracks()
                ->attach($validated["track_id"], ["position" => $nextPosition]);
            return back()->with("success", "Трек добавлен в плейлист.");
        }
        return back()->with("error", "Трек уже есть в этом плейлисте.");
    }
    public function removeTrack(
        Playlist $playlist,
        Track $track,
    ): RedirectResponse {
        $this->authorize("update", $playlist);

        $playlist->tracks()->detach($track->id);
        return back()->with("success", "Трек удален из плейлиста.");
    }
}
