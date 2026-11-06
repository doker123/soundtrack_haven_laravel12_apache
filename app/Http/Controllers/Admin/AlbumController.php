<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Status;
use App\Models\Author;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\Admin\StoreAlbumRequest;
use App\Http\Requests\Admin\UpdateAlbumRequest;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $album = Album::with(["author", "status", "tracks"])
            ->latest()
            ->paginate(12);

        return view("admin.albums.index", compact("album"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $authors = Author::all();
        $statuses = Status::all();
        return view("admin.albums.create", compact("authors", "statuses"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile("cover_path")) {
            $data["cover_path"] = $request
                ->file("cover_path")
                ->store("covers/albums", "public");
        }

        $album = Album::create($data);

        return redirect()
            ->route("admin.albums.show", $album)
            ->with("success", "Альбом создан");
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album): View
    {
        $album->load(["author", "status", "tracks"]);
        return view("admin.albums.show", compact("album"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album): View
    {
        $authors = Author::all();
        $statuses = Status::all();
        return view(
            "admin.albums.edit",
            compact("album", "authors", "statuses"),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateAlbumRequest $request,
        Album $album,
    ): RedirectResponse {
        $data = $request->validated();
        if ($request->hasFile("cover_path")) {
            if (
                $album->cover_path &&
                Storage::disk("public")->exists($album->cover_path)
            ) {
                Storage::disk("public")->delete($album->cover_path);
            }

            $data["cover_path"] = $request
                ->file("cover_path")
                ->store("covers/albums", "public");
        } else {
            unset($data["cover_path"]);
        }

        $album->update($data);

        return redirect()
            ->route("admin.albums.show", $album)
            ->with("success", "Альбом обновлен!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album): RedirectResponse
    {
        if (
            $album->cover_path &&
            Storage::disk("public")->exists($album->cover_path)
        ) {
            Storage::disk("public")->delete($album->cover_path);
        }

        $album->delete();

        return redirect()
            ->route("admin.albums.index")
            ->with("success", "Альбом удален!");
    }
}
