<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Album;
use App\Models\Status;
use App\Models\Author;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use FFMpeg\FFProbe;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Catalog\StoreTrackRequest;
use App\Http\Requests\Catalog\UpdateTrackRequest;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tracks = Track::query()->latest()->get();

        return view("tracks.index", compact("tracks"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $authors = Author::all();
        $albums = Album::all();
        $statuses = Status::all();

        return view("tracks.create", compact("authors", "albums", "statuses"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrackRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $cover = $request->file("cover");
        $file = $request->file("audio");

        $data["cover"] = $request->$file("covers", "local");

        $data["storage_key"] = $file->store("tracks", "local");
        $data["mime_type"] = $file->getMimeType();
        $data["file_size"] = $file->getSize();
        $data["duration_ms"] = $this->resolveDurationMs($data["storage_key"]);

        $track = Track::create($data);

        return redirect()
            ->route("tracks.show", $track)
            ->with("success", "Трек создан");
    }

    /**
     * Display the specified resource.
     */
    public function show(Track $track)
    {
        $track->load(["author", "album.author", "status"]);

        return view("tracks.show", compact("track"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Track $track): View
    {
        $authors = Author::all();
        $albums = Album::all();
        $statuses = Status::all();

        return view(
            "tracks.edit",
            compact("track", "albums", "authors", "statuses"),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateTrackRequest $request,
        Track $track,
    ): RedirectResponse {
        $data = $request->validated();

        if ($file = $request->file("audio")) {

            if ($track->storage_key) {
                Storage::disk("local")->delete($track->storage_key);
            }

            // 2) новый файл + новые метрики
            $data["storage_key"] = $file->store("tracks", "local");
            $data["mime_type"] = $file->getMimeType();
            $data["file_size"] = $file->getSize();

            // 3) пересчёт длительности для нового файла
            $data["duration_ms"] = $this->resolveDurationMs(
                $data["storage_key"],
            );
        }

        $track->update($data);

        return redirect()
            ->route("tracks.show", $track)
            ->with("success", "Трек изменён");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Track $track)
    {
        if ($track->storage_key) {
            Storage::disk("local")->delete($track->storage_key);
        }

        $track->delete();
        return redirect()
            ->route("tracks.index")
            ->with("success", "Трек удален!");
    }
    private function resolveDurationMs(string $storageKey): ?int
    {
        try {
            $ffprobe = FFProbe::create([
                "ffprobe.binaries" => env("FFPROBE_BINARIES", "ffprobe"),
            ]);

            $seconds = (float) $ffprobe
                ->format(Storage::disk("local")->path($storageKey))
                ->get("duration");

            return (int) round($seconds * 1000);
        } catch (\Throwable $e) {
            Log::warning("FFProbe не смог прочитать длительность", [
                "file" => $storageKey,
                "error" => $e->getMessage(),
            ]);

            return null;
        }
    }
}
