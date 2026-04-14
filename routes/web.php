<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\APP\Master\SiswaController as AppSiswaController;
use App\Http\Controllers\API\Master\SiswaController as ApiSiswaController;
use App\Http\Controllers\APP\Settings\UserController as AppUserController;
use App\Http\Controllers\API\Settings\UserController as ApiUserController;
use App\Http\Controllers\APP\Settings\HakAksesController as AppHakAksesController;
use App\Http\Controllers\API\Settings\HakAksesController as ApiHakAksesController;
use App\Http\Controllers\APP\Settings\MenuController as AppMenuController;
use App\Http\Controllers\API\Settings\MenuController as ApiMenuController;

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

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('users',              [AppUserController::class, 'index'])->name('users.index');
        Route::get('users/create',       [AppUserController::class, 'create'])->name('users.create');
        Route::get('users/{user}/edit',  [AppUserController::class, 'edit'])->name('users.edit');

        Route::get('hak-akses',          [AppHakAksesController::class, 'index'])->name('hak_akses.index');

        Route::get('menus',              [AppMenuController::class, 'index'])->name('menus.index');
        Route::get('menus/create',       [AppMenuController::class, 'create'])->name('menus.create');
        Route::get('menus/{menu}/edit',  [AppMenuController::class, 'edit'])->name('menus.edit');
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

    Route::prefix('api/settings')->name('api.settings.')->group(function () {
        Route::get('users/roles',              [ApiUserController::class, 'roles'])->name('users.roles');
        Route::get('users',                    [ApiUserController::class, 'index'])->name('users.index');
        Route::post('users',                   [ApiUserController::class, 'store'])->name('users.store');
        Route::get('users/{user}',             [ApiUserController::class, 'show'])->name('users.show');
        Route::match(['POST', 'PUT'],
                     'users/{user}',           [ApiUserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}',          [ApiUserController::class, 'destroy'])->name('users.destroy');

        Route::get('hak-akses/roles',          [ApiHakAksesController::class, 'roles'])->name('hak_akses.roles');
        Route::get('hak-akses',                [ApiHakAksesController::class, 'index'])->name('hak_akses.index');
        Route::post('hak-akses',               [ApiHakAksesController::class, 'sync'])->name('hak_akses.sync');

        Route::get('menus/parents',            [ApiMenuController::class, 'parents'])->name('menus.parents');
        Route::get('menus',                    [ApiMenuController::class, 'index'])->name('menus.index');
        Route::post('menus',                   [ApiMenuController::class, 'store'])->name('menus.store');
        Route::get('menus/{menu}',             [ApiMenuController::class, 'show'])->name('menus.show');
        Route::match(['POST', 'PUT'],
                     'menus/{menu}',           [ApiMenuController::class, 'update'])->name('menus.update');
        Route::delete('menus/{menu}',          [ApiMenuController::class, 'destroy'])->name('menus.destroy');
    });
});
