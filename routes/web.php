<?php

use App\Http\Controllers\Admin\BoronganController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PenggajianController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Karyawan\KaryawanBoronganController;
use App\Http\Controllers\Karyawan\KaryawanPenggajianController;
use App\Http\Controllers\Karyawan\KaryawanShiftController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('borongan', BoronganController::class);
        Route::post('shifts/batch', [ShiftController::class, 'storeBatch'])->name('shifts.store-batch');
        Route::resource('shifts', ShiftController::class);
        Route::resource('penggajian', PenggajianController::class);
        Route::resource('karyawan', UserController::class);

        Route::resource('laporan', LaporanController::class)->except(['show', 'edit', 'update']);
        Route::get('laporan/{laporan}/download', [LaporanController::class, 'download'])->name('laporan.download');
    });

    Route::middleware(['role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function() {
        Route::get('/dashboard', [KaryawanBoronganController::class, 'index'])->name('dashboard');

        Route::get('/shifts', [KaryawanShiftController::class, 'index'])->name('shifts.index');
        Route::get('/shifts/{shift}', [KaryawanShiftController::class, 'show'])->name('shifts.show');

        // Daftar Borongan Karyawan
        Route::get('/borongan', [KaryawanBoronganController::class, 'index'])->name('borongan.index');
        Route::get('/borongan/{borongan}', [KaryawanBoronganController::class, 'show'])->name('borongan.show');

        // Slip Gaji & Bukti Bayar Karyawan
        Route::get('/penggajian', [KaryawanPenggajianController::class, 'index'])->name('penggajian.index');
        Route::get('/penggajian/{penggajian}', [KaryawanPenggajianController::class, 'show'])->name('penggajian.show');
        Route::get('/penggajian/{penggajian}/download-bukti', [KaryawanPenggajianController::class, 'downloadBukti'])->name('penggajian.download-bukti');
    });
});
