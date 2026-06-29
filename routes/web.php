<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CajaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('sistema-login');
})->name('sistema.login');

Route::post('/login', [AuthController::class, 'login'])->name('cajero.login.post');
Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
Route::get('/caja', [CajaController::class, 'index'])->name('caja');
Route::post('/caja', [CajaController::class, 'vender'])->name('caja.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('cajero.logout.post');
