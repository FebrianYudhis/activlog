<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/app', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
