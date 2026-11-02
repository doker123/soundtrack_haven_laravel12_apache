<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\TrackController;
use App\Http\Controllers\Admin\AlbumController;

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
});
