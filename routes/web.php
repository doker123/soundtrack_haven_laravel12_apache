<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Catalog\AuthorController;
use App\Http\Controllers\Catalog\TrackController;
use App\Http\Controllers\Catalog\AlbumController;

Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/agreement', function () {
    return view('public.agreement');
})->name('agreement');


Route::resource('tracks', TrackController::class)->only(['index', 'show']);
Route::resource('authors', AuthorController::class)->only(['index', 'show']);
Route::resource('albums', AlbumController::class)->only(['index', 'show']);
