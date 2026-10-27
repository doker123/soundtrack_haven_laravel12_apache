<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\Catalog\StoreAuthorRequest;
use App\Http\Requests\Catalog\UpdateAuthorRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $authors = Author::query()->latest()->get();

        return view('authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request): RedirectResponse
    {
            $author = Author::create($request->validated());

            return redirect()
                ->route('authors.show', $author)
                ->with('success', 'Автор создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author): View
    {
        $author->load([
            'avatar',
            'albums' => fn ($q) => $q->with('status')->orderBy('position'),
        ]);

        return view('authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author): View
    {
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author): RedirectResponse
    {
        $author->update($request->validated());

        return redirect()
            ->route('authors.show', $author)
            ->with('success', 'Обновлено');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author): RedirectResponse
    {
        $author->delete();

        return redirect()
            ->route('authors.index')
            ->with('success', 'Автор удалён');
    }
}
