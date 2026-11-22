<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function show(Album $album): View
    {
         abort_if($album->status?->name !== 'published', 404);

        $album->load([
            "author",
            "tracks" => fn($q) => $q->orderBy("created_at", "asc"),
        ]);
        return view("public.albums.show", compact("album"));
    }
}
