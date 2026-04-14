<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|----------------------------------------------------------------------
| Guest Routes
|----------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/',      [AuthController::class, 'loginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'loginForm']);
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|----------------------------------------------------------------------
| Authenticated Routes
|----------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
