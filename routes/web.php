<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransaksiController;
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
Route::middleware(['guest'])->group(function() {
    Route::get('/login', [PagesController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [PagesController::class, 'home']);
    Route::middleware(['role:admin,kasir'])->group(function () {
        Route::get('/data/member', [PagesController::class, 'member']);
        Route::get('/transaksi/baru', [PagesController::class, 'transaksi']);
        Route::get('/transaksi/pembayaran', [PagesController::class, 'transaksiPembayaran']);
        Route::get('/transaksi/list', [PagesController::class, 'daftarTransaksi']);
    });
    Route::middleware(['role:admin,kasir,owner'])->group(function () {
        Route::get('/laporan/transaksi', [PagesController::class, 'laporanTransaksi']);
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [PagesController::class, 'dashboard']);
        Route::get('/data/outlet', [PagesController::class, 'outlet']);
        Route::get('/data/karyawan', [PagesController::class, 'karyawan']);
        Route::get('/data/paket', [PagesController::class, 'paket']);
        Route::get('/log-aktivitas', [PagesController::class, 'logAktivitas']);
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('/api/outlet', OutletController::class);
    Route::resource('/api/member', MemberController::class);
    Route::resource('/api/user', UserController::class);
    Route::resource('/api/paket', PaketController::class);
    Route::get('/api/transaksi', [TransaksiController::class, 'index']);
    Route::get('/api/transaksi/non-cash', [TransaksiController::class, 'getNonCashData']);
    Route::post('/api/transaksi/store', [TransaksiController::class, 'store']);
    Route::post('/api/transaksi/update', [TransaksiController::class, 'update']);

    // Laporan
    Route::get('/api/laporan/transaksi', [LaporanController::class, 'getLaporanTransaksi']);
    Route::get('/api/laporan/transaksi/between/{startDate}/{endDate}', [LaporanController::class, 'getLaporanTransaksiBetweenDate']);
    Route::get('/api/laporan/transaksi/export-pdf', [ExportController::class, 'exportPDF']);
    Route::get('/api/laporan/transaksi/export-excel', [ExportController::class, 'exportExcel']);

    Route::get('/api/log-activity/all', [LogActivityController::class, 'getAllActivities']);
});
