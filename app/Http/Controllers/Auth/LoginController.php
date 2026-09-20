<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;


class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember');

        if(! Auth::attempt($credentials, $remember)) {
            return back()->withInput($request->only('email'))->withErrors(['email' => 'Неверные учетные данные']);
        }
        $request->session()->regenerate();
        return redirect()->intended(route('home'));
    }
}
