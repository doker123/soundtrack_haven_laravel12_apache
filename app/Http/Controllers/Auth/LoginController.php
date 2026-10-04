<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
<<<<<<< HEAD
use App\Http\Requests\Auth\LoginRequest;
use App\Service\Auth\LoginService;
=======
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
>>>>>>> 038e6ed9c9af2bc2a8870ec57e3c792290d0c498


class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

<<<<<<< HEAD
    public function store(LoginRequest $request, LoginService $loginService): RedirectResponse
    {
        $validated = $request->validated();
        $remember = $request->boolean('remember');
        $loginService->attemptLogin($validated, $remember);
=======
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember');

        if(! Auth::attempt($credentials, $remember)) {
            return back()->withInput($request->only('email'))->withErrors(['email' => 'Неверные учетные данные']);
        }
        $request->session()->regenerate();
>>>>>>> 038e6ed9c9af2bc2a8870ec57e3c792290d0c498
        return redirect()->intended(route('home'));
    }
}
