<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::controller(UserController::class)->group(function () {
    Route::prefix('login')->group(function () {
        Route::name('login.')->group(function () {
            Route::get('/', 'loginForm');
            Route::post('/', 'login')->name('signin');
            Route::get('/logout', 'logout')->name('signout');
        });
    });
});

Route::middleware('login')->group(function () {
    Route::controller(IndexController::class)->group(function () {
        Route::prefix('/')->group(function () {
            Route::name('home.')->group(function () {
                Route::get('/', 'index')->name('index');
            });
        });
    });

    Route::controller(PeriodeController::class)->group(function () {
        Route::prefix('periode')->group(function () {
            Route::name('periode.')->group(function () {
                Route::get('/', 'index');
                Route::get('/list', 'dataTables')->name('list');
                Route::put('/{id}', 'update')->name('update');
                Route::get('/{id}', 'view')->name('view');
                Route::post('/', 'store')->name('store');
            });
        });
    });

    Route::controller(KaryawanController::class)->group(function () {
        Route::prefix('karyawan')->group(function () {
            Route::name('karyawan.')->group(function () {
                Route::get('/', 'index');
                Route::get('/list', 'dataTables')->name('list');
                Route::post('/', 'store')->name('store');
            });
        });
    });

    Route::controller(PenggajianController::class)->group(function () {
        Route::get('/penggajian', 'index');
    });

    Route::controller(BarangController::class)->group(function () {
        Route::get('/barang', 'index');
    });
});
