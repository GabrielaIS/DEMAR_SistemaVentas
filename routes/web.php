<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CajaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CajeroController;

Route::get('/', function () {
    return view('sistema-login');
})->name('sistema.login');

Route::post('/login', [AuthController::class, 'login'])->name('cajero.login.post');
Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
Route::get('/caja', [CajaController::class, 'index'])->name('caja');
Route::post('/caja', [CajaController::class, 'vender'])->name('caja.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('cajero.logout.post');

Route::post('/admin/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('/admin/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/admin/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::post('/admin/cajeros', [CajeroController::class, 'store'])->name('cajeros.store');
Route::put('/admin/cajeros/{cajero}', [CajeroController::class, 'update'])->name('cajeros.update');
Route::delete('/admin/cajeros/{cajero}', [CajeroController::class, 'destroy'])->name('cajeros.destroy');