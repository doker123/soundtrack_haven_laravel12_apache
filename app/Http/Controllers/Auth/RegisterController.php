<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Service\Auth\RegisterService;

class RegisterController extends Controller
{
    public function show(): View
    {
        return view("auth.register");
    }

    public function store(RegisterRequest $request, RegisterService $registerService): RedirectResponse
    {
        $validated = $request->validated();

        $user = $registerService->attemptRegistration($validated);

        return redirect()->route("home");
    }
}
