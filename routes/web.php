<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\KontrakSewaController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('pembayaran/export', [App\Http\Controllers\PembayaranController::class, 'export'])->name('pembayaran.export');

Route::resource('kamar', \App\Http\Controllers\KamarController::class);
Route::resource('penyewa', \App\Http\Controllers\PenyewaController::class);
Route::resource('kontrak', \App\Http\Controllers\KontrakSewaController::class);
Route::resource('pembayaran', \App\Http\Controllers\PembayaranController::class);
