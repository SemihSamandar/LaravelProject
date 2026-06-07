<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminOrderController;

// ===== 1. AUTH ROUTES =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== 2. PUBLIC ROUTES =====
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.list');

// SEPET SAYFASI
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// ===== 3. PROTECTED ROUTES (Giriş Yapmış Kullanıcılar & Admin) =====
Route::middleware(['auth'])->group(function () {
    
    // Admin Siparişleri (En üstte olmalı)
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    
    // Ürün Yönetimi (Sıralama kritik: 'create' her zaman '{id}' yapısından ÖNCE gelmelidir)
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// ===== 4. PUBLIC PRODUCT DETAIL (En Altta Olmalı ki 'create' kelimesini yutmasın) =====
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// ===== 5. API CART =====
Route::prefix('api/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/count', [CartController::class, 'count'])->name('cart.count');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});