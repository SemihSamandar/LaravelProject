<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== PUBLIC ROUTES =====

// Ürünleri Listele (Ana Sayfa)
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.list');

// ===== AUTH ROUTES =====

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== PROTECTED ROUTES (Admin - Giriş Gerekli) =====
Route::middleware(['auth'])->prefix('products')->group(function () {
    // Yeni ürün ekleme formu
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');

    // Ürünü veritabanına kaydet
    Route::post('/', [ProductController::class, 'store'])->name('products.store');

    // Ürün detaylarını göster
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');

    // Ürün düzenleme formunu göster
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

    // Ürünü güncelle
    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');

    // Ürünü sil
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});
