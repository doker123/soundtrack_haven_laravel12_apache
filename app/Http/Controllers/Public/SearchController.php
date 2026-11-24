<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Author;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $type  = (string) $request->input('type', 'all');

        $allowedTypes = ['all', 'tracks', 'albums', 'authors', 'playlists'];
        if (!in_array($type, $allowedTypes, true)) {
            $type = 'all';
        }

        $tracks = collect();
        $albums = collect();
        $authors = collect();
        $playlists = collect();

        $counts = [
            'tracks'    => 0,
            'albums'    => 0,
            'authors'   => 0,
            'playlists' => 0,
            'total'     => 0,
        ];

        if (mb_strlen($query) >= 2) {
            $searchTerm = "%{$query}%";

            $tracksQuery = Track::published()
                ->with(['author', 'album'])
                ->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhereHas('author', function ($authorQuery) use ($searchTerm) {
                          $authorQuery->where('name', 'like', $searchTerm);
                      });
                })
                ->latest('id');

            $albumsQuery = Album::published()
                ->with('author')
                ->withCount('tracks')
                ->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm)
                      ->orWhereHas('author', function ($authorQuery) use ($searchTerm) {
                          $authorQuery->where('name', 'like', $searchTerm);
                      });
                })
                ->latest('id');

            $authorsQuery = Author::where('name', 'like', $searchTerm)
                ->orWhere('bio', 'like', $searchTerm)
                ->withCount(['albums', 'tracks'])
                ->latest('id');

            $playlistsQuery = Playlist::with('user')
                ->withCount('tracks')
                ->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm);
                })
                ->where(function ($q) {
                    $q->where('is_public', true);
                    if (Auth::check()) {
                        $q->orWhere('user_id', Auth::id());
                    }
                })
                ->latest('id');

            $counts['tracks']    = (clone $tracksQuery)->count();
            $counts['albums']    = (clone $albumsQuery)->count();
            $counts['authors']   = (clone $authorsQuery)->count();
            $counts['playlists'] = (clone $playlistsQuery)->count();
            $counts['total']     = array_sum($counts);

            if ($type === 'tracks') {
                $tracks = $tracksQuery->paginate(20)->withQueryString();
            } elseif ($type === 'albums') {
                $albums = $albumsQuery->paginate(15)->withQueryString();
            } elseif ($type === 'authors') {
                $authors = $authorsQuery->paginate(18)->withQueryString();
            } elseif ($type === 'playlists') {
                $playlists = $playlistsQuery->paginate(15)->withQueryString();
            } else {
                $tracks    = $tracksQuery->take(9)->get();
                $albums    = $albumsQuery->take(5)->get();
                $authors   = $authorsQuery->take(6)->get();
                $playlists = $playlistsQuery->take(5)->get();
            }
        }

        return view('public.search.index', compact(
            'query',
            'type',
            'counts',
            'tracks',
            'albums',
            'authors',
            'playlists'
        ));
    }
}
