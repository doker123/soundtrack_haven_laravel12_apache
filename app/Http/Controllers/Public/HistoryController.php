<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ListeningHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $history = ListeningHistory::with(['track.author', 'track.album'])
            ->ofUser($user->id)
            ->recent()
            ->paginate(30);


        $totalPlays = ListeningHistory::ofUser($user->id)->count();

        $totalMs = ListeningHistory::ofUser($user->id)->sum('played_duration_ms');

        $uniqueTracks = ListeningHistory::ofUser($user->id)
            ->distinct('track_id')
            ->count('track_id');

        return view('public.history.index', compact(
            'history',
            'totalPlays',
            'totalMs',
            'uniqueTracks',
        ));
    }
}
