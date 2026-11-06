<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\TrackController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

// Маршруты для гостей (доступны только неавторизованным)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');
});



Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/agreement', function () {
    return view('public.agreement');
})->name('agreement');


Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::resource('tracks', TrackController::class);
        Route::resource('authors', AuthorController::class);
        Route::resource('albums', AlbumController::class);
        Route::resource('users', UserController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::post('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::post('users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
});
