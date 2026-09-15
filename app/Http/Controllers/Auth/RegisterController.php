<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view("auth.register");
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => [
                "required",
                "string",
                "email",
                "max:255",
                "unique:users",
            ],
            "password" => ["required", "confirmed", Rules\Password::defaults()],
        ]);

        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => $validated["password"],
        ]);

        Auth::login($user);

        return redirect()->route("home");
    }
    
    // public function showAdminRegisterForm(Request $request): View
    // {
    //     return view('auth.admin-register');
    // }

    // public function adminRegister(Request $request): RedirectResponse
    // {
    //     $validated = $request->validate([
    //         "name" => ["required", "string", "max:255"],
    //         "email" => [
    //             "required",
    //             "string",
    //             "email",
    //             "max:255",
    //             "unique:users",
    //         ],
    //         "password" => ["required", "confirmed", Rules\Password::defaults()],
    //         "is_admin" => ["boolean", "required"],
    //     ]);

    //     $user = User::create([
    //         "name" => $validated["name"],
    //         "email" => $validated["email"],
    //         "password" => $validated["password"],
    //         "is_admin"=> filter_var($validated["is_admin"], FILTER_VALIDATE_BOOLEAN),
    //     ]); 

    //     Auth::login($user);
        

    //     return redirect()->route("home");
    // }
}
