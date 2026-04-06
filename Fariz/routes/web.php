<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;

// 1. HALAMAN PUBLIK
Route::get('/', function () {
    return view('welcome');
});

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// 2. HALAMAN KHUSUS LOGIN (User & Admin)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // DASHBOARD REDIRECTOR (Pintu Otomatis)
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            // Ambil data pesanan terbaru untuk admin
            $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
            return view('admin.dashboard', compact('recentOrders')); 
        }
        return view('dashboard'); 
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Fitur User Biasa
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update-cart', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // 3. AREA KHUSUS ADMIN
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            if (Auth::user()->role !== 'admin') return redirect('/dashboard');
            
            // Sama seperti di atas, ambil data pesanan buat dashboard admin
            $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
            return view('admin.dashboard', compact('recentOrders'));
        })->name('admin.dashboard');

        // CRUD Produk (Hanya Admin)
        Route::resource('products', ProductController::class)->names([
            'index' => 'admin.products.index',
        ]);

        // Pesanan
        Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
        Route::patch('/orders/{id}', [OrderController::class, 'updateStatus'])->name('admin.orders.update');
    });
});

require __DIR__.'/auth.php';