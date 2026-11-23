<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AudioStreamController extends Controller
{
    public function stream(Request $request, Track $track): BinaryFileResponse
    {
        if (!$track->status || $track->status->name !== "published") {
            abort(403, "Трек не доступен для прослушивания");
        }

        if (
            !$track->storage_key ||
            !Storage::disk("local")->exists($track->storage_key)
        ) {
            abort(404, "Аудиофайл не найден на сервере.");
        }

        $fullPath = Storage::disk("local")->path($track->storage_key);
        $mimeType = Storage::disk("local")->mimeType($track->storage_key) ?: ($track->mime_type ?? "audio/mpeg");

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        return response()->file($fullPath, [
            "Content-Type" => $mimeType,
            "Accept-Ranges" => "bytes",
            "Cache-Control" => "no-cache, private",
        ]);
    }

    public function recordHistory(Request $request, Track $track): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(["status" => "guest_ignored"], 200);
        }

        $validated = $request->validate([
            "played_duration_ms" => ["required", "integer", "min:1000"],
        ]);

        $user = $request->user();

        $user->listeningHistory()->create([
            "track_id" => $track->id,
            "played_duration_ms" => $validated["played_duration_ms"],
            "played_at" => now(),
        ]);

        return response()->json([
            "status" => "success",
            "message" => "История прослушивания обновлена",
        ]);
    }
}
