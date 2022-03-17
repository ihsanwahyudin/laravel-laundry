<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangInventarisController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PenjemputanController;
use App\Http\Controllers\TestController;
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
    Route::get('/forgot-password', [PagesController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [PagesController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [PagesController::class, 'home']);
    Route::middleware(['role:admin,kasir'])->group(function () {
        Route::get('/data/member', [PagesController::class, 'member']);
        Route::get('/transaksi/baru', [PagesController::class, 'transaksi']);
        Route::get('/transaksi/pembayaran', [PagesController::class, 'transaksiPembayaran']);
        Route::get('/transaksi/list', [PagesController::class, 'daftarTransaksi']);
        Route::get('/penjemputan', [PagesController::class, 'penjemputan']);
        Route::put('/api/penjemputan/update-status/{id}', [PenjemputanController::class, 'updateStatus']);
        Route::resource('/api/penjemputan', PenjemputanController::class);
    });
    Route::middleware(['role:admin,kasir,owner'])->group(function () {
        Route::get('/laporan/transaksi', [PagesController::class, 'laporanTransaksi']);
    });
    Route::middleware(['role:admin,owner'])->group(function () {
        Route::get('/dashboard', [PagesController::class, 'dashboard']);
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/data/outlet', [PagesController::class, 'outlet']);
        Route::get('/data/karyawan', [PagesController::class, 'karyawan']);
        Route::get('/data/paket', [PagesController::class, 'paket']);
        Route::get('/log-aktivitas', [PagesController::class, 'logAktivitas']);
        Route::get('/data/barang-inventaris', [PagesController::class, 'barangInventaris']);
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('/api/outlet', OutletController::class);
    Route::resource('/api/member', MemberController::class);
    Route::resource('/api/user', UserController::class);
    Route::resource('/api/paket', PaketController::class);
    Route::resource('/api/barang-inventaris', BarangInventarisController::class);
    Route::get('/api/data/transaksi/{type}', [TransaksiController::class, 'filter']);
    Route::get('/api/transaksi', [TransaksiController::class, 'index']);
    Route::get('/api/transaksi/non-cash', [TransaksiController::class, 'getNonCashData']);
    Route::post('/api/transaksi/store', [TransaksiController::class, 'store']);
    Route::post('/api/transaksi/update', [TransaksiController::class, 'update']);
    Route::post('/api/transaksi/update/status-transaksi', [TransaksiController::class, 'updateStatusTransaksi']);
    Route::get('/api/transaksi/cetak-faktur/{noInvoice}', [TransaksiController::class, 'cetakFaktur']);

    // Laporan
    Route::get('/api/laporan/transaksi', [LaporanController::class, 'getLaporanTransaksi']);
    Route::get('/api/laporan/transaksi/between/{startDate}/{endDate}', [LaporanController::class, 'getLaporanTransaksiBetweenDate']);
    Route::get('/api/laporan/transaksi/export-pdf', [ExportController::class, 'exportPDF']);
    Route::get('/api/laporan/transaksi/export-excel', [ExportController::class, 'exportExcel']);
    Route::get('/api/laporan/transaksi/export-pdf/{startDate}/{endDate}', [ExportController::class, 'exportPDFFilterByDate']);
    Route::get('/api/laporan/transaksi/export-excel/{startDate}/{endDate}', [ExportController::class, 'exportExcelFilterByDate']);
    // Dashboard
    Route::get('/api/laporan/income/current-month', [LaporanController::class, 'getIncomeCurrentMonth']);
    Route::get('/api/laporan/transaction-amount', [LaporanController::class, 'getTransactionAmount']);
    Route::get('/api/laporan/number-of-member', [LaporanController::class, 'getNumberOfMember']);
    Route::get('/api/laporan/recently-transaction', [LaporanController::class, 'getRecentlyTransaction']);
    Route::get('/api/laporan/income-per-day/current-month', [LaporanController::class, 'getIncomePerDayCurrentMonth']);
    Route::get('/api/laporan/recently-activity', [LaporanController::class, 'getRecentlyActivity']);
    Route::get('/api/laporan/latest-transaction/{limit}', [LaporanController::class, 'getLatestTransaction']);
    Route::get('/api/laporan/amount-of-transaction/per-status-transaction', [LaporanController::class, 'getAmountOfTransactionPerStatusTransaction']);
    Route::get('/api/laporan/amount-of-transaction/per-day-per-status-transaction', [LaporanController::class, 'getAmountOfTransactionPerDayPerStatusTransaction']);
    Route::get('/api/laporan/number-of-member/per-gender', [LaporanController::class, 'getNumberOfMemberPerGender']);

    Route::get('/api/log-activity/all', [LogActivityController::class, 'getAllActivities']);
    Route::post('/api/log-activity/filter', [LogActivityController::class, 'filterActivities']);

    Route::get('/member/export-excel', [ExportController::class, 'exportMemberExcel']);
    Route::post('/member/import-excel', [ImportController::class, 'importMemberExcel']);
    Route::get('/outlet/export-excel', [ExportController::class, 'exportOutletExcel']);
    Route::post('/outlet/import-excel', [ImportController::class, 'importOutletExcel']);
    Route::get('/paket/export-excel', [ExportController::class, 'exportPaketExcel']);
    Route::post('/paket/import-excel', [ImportController::class, 'importPaketExcel']);
    Route::get('/barang-inventaris/export-excel', [ExportController::class, 'exportBarangInventarisExcel']);
    Route::post('/barang-inventaris/import-excel', [ImportController::class, 'importBarangInventarisExcel']);
    Route::get('/penjemputan/export-excel', [ExportController::class, 'exportPenjemputanExcel']);
    Route::post('/penjemputan/import-excel', [ImportController::class, 'importPenjemputanExcel']);
});


Route::get('/test', [TestController::class, 'test2']);
Route::post('/test/simpan', [TestController::class, 'simpan'])->name('test.simpan');

Route::get('/kelola/gaji', [PagesController::class, 'kelolaGaji']);
// Route::get('/data/karyawan', [TestController::class, 'getDataKaryawan']);
