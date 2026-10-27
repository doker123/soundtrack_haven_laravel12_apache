<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Status;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\Catalog\StoreAlbumRequest;
use App\Http\Requests\Catalog\UpdateAlbumRequest;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $album = Album::query()->latest()->get();

        return view('albums.index', compact('album'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $authors = Author::all();
        $statuses = Status::all();
        return view('albums.create', compact('authors', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request): RedirectResponse
    {
        $albums = Album::create($request->validated());

        return redirect()
            ->route('albums.show', $albums)
            ->with('success', 'Альбом создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album): View
    {
        $album->load(['author', 'status', 'tracks']);
        return view('albums.show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album): View
    {
        $authors = Author::all();
        $status = Status::all(); 
        return view('albums.edit', compact('album', 'authors', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlbumRequest $request, Album $album): RedirectResponse
    {
        $album->update($request->validated());
        return redirect()->route('albums.show', $album)->with('success', 'Альбом обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album): RedirectResponse
    {
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Альбом удален!');
    }
}
