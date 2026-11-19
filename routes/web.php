<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Halaman UI Kasir & Bukti Transaksi
Route::get('/warteg', function () {
    return view('warteg');
});

// 1. Rute Publik (Bisa diakses siapa saja tanpa login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/menus', [MenuController::class, 'index']);

// 2. Rute yang Wajib Login (Semua Role: admin & customer)
Route::middleware('auth')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Customer & Admin bisa bikin pesanan
    Route::post('/transactions', [TransactionController::class, 'store']);
});

// 3. Rute Khusus Admin/Kasir Saja
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index']);

    // CRUD & upload gambar menu khusus admin
    Route::post('/menus', [MenuController::class, 'store']);
    Route::get('/menus/{id}', [MenuController::class, 'show']);
    Route::post('/menus/{id}', [MenuController::class, 'update']);
    Route::put('/menus/{id}', [MenuController::class, 'update']);
    Route::delete('/menus/{id}', [MenuController::class, 'destroy']);
});