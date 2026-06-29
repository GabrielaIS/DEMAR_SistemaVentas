<?php

use App\Http\Controllers\CajaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('sistema-login');
})->name('sistema.login');

Route::post('/login', [CajaController::class, 'login'])->name('cajero.login.post');
Route::get('/admin', [CajaController::class, 'admin'])->name('admin');
Route::get('/caja', [CajaController::class, 'index'])->name('caja');
Route::post('/caja', [CajaController::class, 'vender'])->name('caja.post');
Route::post('/logout', [CajaController::class, 'logout'])->name('cajero.logout.post');
