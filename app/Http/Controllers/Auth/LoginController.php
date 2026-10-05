<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Service\Auth\LoginService;


class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(LoginService $loginService): RedirectResponse
    {
        $loginService->attemptLogin(request()->only(['email', 'password']), request()->boolean('remember'));
        return redirect()->intended(route('home'));
    }
}
