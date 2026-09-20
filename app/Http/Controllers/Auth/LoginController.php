<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\Auth\LoginRequest;
use App\Service\Auth\LoginService;


class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request, LoginService $loginService): RedirectResponse
    {
        $validated = $request->validated();
        $remember = $request->boolean('remember');
        $loginService->attemptLogin($validated, $remember);
        return redirect()->intended(route('home'));
    }
}
