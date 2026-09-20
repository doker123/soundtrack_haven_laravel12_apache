<?php
namespace App\Service\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function attemptLogin( array $credentials, bool $remember = false ): bool
    {
        if (!Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }
        request()->session()->regenerate();
        return true;
    }
}
