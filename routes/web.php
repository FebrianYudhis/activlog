<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showLoginForm']);

Auth::routes();

Route::get('/app', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
