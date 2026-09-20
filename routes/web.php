<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/agreement', function () {
    return view('public.agreement');
})->name('agreement');
