<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\TunjanganController;
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

    Route::get('/health', 'health')->name('health');
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
                Route::get('/{id}', 'view')->name('view');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::put('/status/{id}', 'statusKaryawan')->name('statusKaryawan');
            });
        });
    });

    Route::controller(BarangController::class)->group(function () {
        Route::prefix('barang')->group(function () {
            Route::name('barang.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::get('/list', 'dataTables')->name('list');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}/destroyItem', 'destroyItem')->name('destroy.item');
            });
        });
    });

    Route::controller(PenggajianController::class)->group(function () {
        Route::prefix('penggajian')->group(function () {
            Route::name('penggajian.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/list', 'dataTables')->name('list');
                Route::get('/listGaji', 'dataTablesGaji')->name('listGaji');
                Route::get('/optPenggajian', 'preparePagePenggajian')->name('optPenggajian');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::get('/{karyawanId}/{periodeId}', 'show')->name('show');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::put('/{id}', 'update')->name('update');

                Route::prefix('gaji')->group(function () {
                    Route::delete('/{id}', 'deleteDataGaji')->name('destroy.gaji');
                    Route::get('/refreshTotalGaji/{id}', 'refreshTotalGaji')->name('refreshTotalGaji');
                });
            });
        });
    });

    Route::controller(TunjanganController::class)->group(function () {
        Route::prefix('tunjangan')->group(function () {
            Route::name('tunjangan.')->group(function () {
                Route::get('/listTunjangan', 'dataTables')->name('listTunjangan');
                Route::get('/{id}', 'show')->name('show');
                Route::post('/', 'store')->name('store');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
        });
    });
});
