<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    public function show(Author $author)
    {
        $author->load([
            'albums' => fn($q) => $q->latest(),
            'tracks.album'
        ]);

        return view('public.authors.show', compact('author'));
    }
}
