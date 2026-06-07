<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminOrderController;



// Bu satır, sidebar'daki route('admin.orders.index') ifadesinin çalışmasını sağlayacak
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
// ===== PUBLIC ROUTES =====




// Ana sayfa
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.list');

// ✅ SEPET SAYFASI (BURAYA EKLE!)
Route::get('/cart', function () {
    return view('cart');
})->name('cart');


// ===== AUTH ROUTES =====

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ===== PROTECTED ROUTES =====
Route::middleware(['auth'])->prefix('products')->group(function () {
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});


// ===== API CART =====
Route::prefix('api/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/{cart}/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/{cart}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/count', [CartController::class, 'count'])->name('cart.count');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});