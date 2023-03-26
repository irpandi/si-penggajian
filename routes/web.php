<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\PeriodeController;
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

Route::controller(IndexController::class)->group(function () {
    Route::get('/', 'index');
});

Route::controller(PeriodeController::class)->group(function () {
    Route::get('/periode', 'index');
});

Route::controller(KaryawanController::class)->group(function () {
    Route::get('/karyawan', 'index');
});

Route::controller(PenggajianController::class)->group(function () {
    Route::get('/penggajian', 'index');
});

Route::controller(BarangController::class)->group(function () {
    Route::get('/barang', 'index');
});
