<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
<<<<<<< HEAD
use App\Http\Controllers\Auth\LogoutController;
=======
>>>>>>> 038e6ed9c9af2bc2a8870ec57e3c792290d0c498
use App\Http\Controllers\Auth\RegisterController;



// Маршруты для гостей (доступны только неавторизованным)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
<<<<<<< HEAD

});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');
});
=======
});
>>>>>>> 038e6ed9c9af2bc2a8870ec57e3c792290d0c498
