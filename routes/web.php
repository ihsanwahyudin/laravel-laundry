<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PagesController;
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
    Route::get('/dashboard', [PagesController::class, 'dashboard']);
    Route::get('/data/outlet', [PagesController::class, 'outlet']);
    Route::get('/data/member', [PagesController::class, 'member']);
    Route::get('/data/karyawan', [PagesController::class, 'karyawan']);

    Route::resource('/api/outlet', OutletController::class);
    Route::resource('/api/member', MemberController::class);
    Route::resource('/api/user', UserController::class);
});
