<?php

use App\Http\Controllers\Auth\{LoginController, RegisterController};
use App\Http\Controllers\{HomeController, LogbookController};
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/app');

Route::group([], function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('app', HomeController::class)->name('app');

    Route::prefix('app/logbook')->group(function () {
        Route::get('tambah', [LogbookController::class, 'tambahForm'])->name('logbook.tambah');
        Route::post('tambah', [LogbookController::class, 'tambah']);
        Route::delete('hapus/{date_schedule}', [LogbookController::class, 'hapus'])->name('logbook.hapus');
        Route::patch('status/{status}/{date_schedule}', [LogbookController::class, 'updateStatus'])->name('logbook.status');

        Route::patch('catatan/{note}', [LogbookController::class, 'updateCatatan'])->name('logbook.catatan');
        Route::delete('task/{task}/hapus', [LogbookController::class, 'hapusTugas'])->name('logbook.tugas.hapus');

        Route::get('{date_schedule}', [LogbookController::class, 'index'])->name('logbook');
    });
});
