<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\APP\Master\SiswaController as AppSiswaController;
use App\Http\Controllers\API\Master\SiswaController as ApiSiswaController;

/*
|----------------------------------------------------------------------
| Guest Routes
|----------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/',      [AuthController::class, 'loginForm']);
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|----------------------------------------------------------------------
| Authenticated Routes
|----------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |------------------------------------------------------------------
    | APP Routes — hanya mengembalikan view
    |------------------------------------------------------------------
    */
    Route::prefix('master')->name('master.')->group(function () {
        Route::get('siswa',              [AppSiswaController::class, 'index'])->name('siswa.index');
        Route::get('siswa/create',       [AppSiswaController::class, 'create'])->name('siswa.create');
        Route::get('siswa/{siswa}/edit', [AppSiswaController::class, 'edit'])->name('siswa.edit');
    });

    /*
    |------------------------------------------------------------------
    | API Routes — mengembalikan JSON
    |------------------------------------------------------------------
    */
    Route::prefix('api/master')->name('api.master.')->group(function () {
        Route::get('siswa',                    [ApiSiswaController::class, 'index'])->name('siswa.index');
        Route::post('siswa',                   [ApiSiswaController::class, 'store'])->name('siswa.store');
        Route::get('siswa/{siswa}',            [ApiSiswaController::class, 'show'])->name('siswa.show');
        Route::match(['POST', 'PUT'],
                     'siswa/{siswa}',          [ApiSiswaController::class, 'update'])->name('siswa.update');
        Route::delete('siswa/{siswa}',         [ApiSiswaController::class, 'destroy'])->name('siswa.destroy');
    });
});
