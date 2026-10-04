<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Service\Auth\RegisterService;
=======
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
>>>>>>> 038e6ed9c9af2bc2a8870ec57e3c792290d0c498

class RegisterController extends Controller
{
    public function show(): View
    {
        return view("auth.register");
    }

<<<<<<< HEAD
    public function store(RegisterRequest $request, RegisterService $registerService): RedirectResponse
    {
        $validated = $request->validated();

        $user = $registerService->attemptRegistration($validated);

        return redirect()->route("home");
    }
}
=======
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => Hash::make($validated["password"]),
        ]);
        event(new Registered($user));
        
        Auth::login($user);
        return redirect()->route("home");
    }
}
>>>>>>> 038e6ed9c9af2bc2a8870ec57e3c792290d0c498
