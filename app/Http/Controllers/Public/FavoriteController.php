<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Страница избранных треков пользователя.
     */
    public function index()
    {
        $tracks = Auth::user()
            ->favoriteTracks()
            ->with(['author', 'album'])
            ->paginate(30);

        return view('public.favorites.index', compact('tracks'));
    }

    /**
     * Добавить/убрать трек из избранного (toggle).
     */
    public function toggle(Track $track)
    {
        $user = Auth::user();

        if ($user->favoriteTracks()->where('track_id', $track->id)->exists()) {
            $user->favoriteTracks()->detach($track->id);
            $isFavorite = false;
        } else {
            $user->favoriteTracks()->attach($track->id);
            $isFavorite = true;
        }

        if (request()->expectsJson()) {
            return response()->json(['favorite' => $isFavorite]);
        }

        return back();
    }
}
