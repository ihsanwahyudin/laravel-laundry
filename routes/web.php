<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PagesController;
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

    Route::resource('/outlet', OutletController::class);
});
