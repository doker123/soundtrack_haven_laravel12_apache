<?php

use Illuminate\Support\Facades\Route;

<<<<<<< HEAD
Route::get('/', function () {return view('public.home');})->name('home');
Route::get('/agreement', function () {return view('public.agreement');})->name('agreement');


=======
Route::get('/', function () {
    return view('public.home');
})->name('home');
>>>>>>> 038e6ed9c9af2bc2a8870ec57e3c792290d0c498

Route::get('/agreement', function () {
    return view('public.agreement');
})->name('agreement');
