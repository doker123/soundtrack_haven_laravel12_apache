<?php

namespace App\Http\Controllers\Public;

use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return view("playlists.index", compact("playlists"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("playlists.create");
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
                "title" => $validated["title"],
                "description" => $validated["description"] ?? null,
                "cover_path" => $coverPath,
                "is_public" => $request->boolean("is_public"),
            ]);
            
            return redirect()->route('playlists.show', $playlist)->with('success', 'Плейлист создан!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Playlist $playlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        //
    }
}
