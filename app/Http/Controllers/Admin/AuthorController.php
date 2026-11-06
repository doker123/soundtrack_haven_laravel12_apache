<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreAuthorRequest;
use App\Http\Requests\Admin\UpdateAuthorRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $authors = Author::withCount(["albums", "tracks"])
            ->latest()
            ->paginate(15);

        return view("admin.authors.index", compact("authors"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("admin.authors.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile("image")) {
            $data["image"] = $request
                ->file("image")
                ->store("authors", "public");
        }

        $author = Author::create($data);

        return redirect()
            ->route("admin.authors.show", $author)
            ->with("success", "Автор создан");
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author): View
    {
        $author->load([
            "albums" => fn($q) => $q->with("status")->orderBy("position"),
        ]);

        return view("admin.authors.show", compact("author"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author): View
    {
        return view("admin.authors.edit", compact("author"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateAuthorRequest $request,
        Author $author,
    ): RedirectResponse {
        $data = $request->validated();

        if ($request->hasFile("image")) {
            if (
                $author->image &&
                Storage::disk("public")->exists($author->image)
            ) {
                Storage::disk("public")->delete($author->image);
            }
            $data["image"] = $request
                ->file("image")
                ->store("authors", "public");
        }
        $author->update($data);

        return redirect()
            ->route("admin.authors.show", $author)
            ->with("success", "Обновлено");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author): RedirectResponse
    {
        if ($author->image && Storage::disk("public")->exists($author->image)) {
            Storage::disk("public")->delete($author->image);
        }

        $author->delete();

        return redirect()
            ->route("admin.authors.index")
            ->with("success", "Автор удалён");
    }
}
