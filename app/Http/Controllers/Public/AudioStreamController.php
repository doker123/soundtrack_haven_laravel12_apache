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
    public function stream(Track $track): BinaryFileResponse
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
        $headers = [
            "Content-Type" => $track->mime_type ?? "audio/mpeg",
            "Content-Disposition" =>
                'inline; filename="' . addslashes($track->title) . '.mp3"',
            "Accept-Ranges" => "bytes",
            "Cache-Control" => "no-cache, private",
        ];

        $response = response()->file($fullPath, $headers);
        BinaryFileResponse::trustXSendfileTypeHeader();

        return $response;
    }

    public function recordHistory(Request $request, Track $track): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(["status" => "guest_ignored"], 200);
        }
        $validated = $request->validate([
            "played_duration_ms" => ["required", "integer", "min:1000"], // минимум 1 секунда
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
