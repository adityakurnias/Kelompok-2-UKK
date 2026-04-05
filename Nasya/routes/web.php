<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;

// --- 1. HALAMAN PUBLIK (Tanpa Login) ---
Route::get('/', function () { return view('welcome'); });

// Katalog untuk Pengunjung Umum
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


// --- 2. HALAMAN KHUSUS LOGIN (User & Admin) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // DASHBOARD REDIRECTOR
    Route::get('/dashboard', function () {
        if (strtolower(Auth::user()->role) === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Profile & Fitur Belanja User Biasa
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update-cart', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');


        // --- 3. AREA KHUSUS ADMIN ---
        Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

            // Dashboard Admin (Cek role langsung di dalam fungsi)
            Route::get('/dashboard', function () {
                if (strtolower(Auth::user()->role) !== 'admin') {
                    return redirect('/dashboard')->with('error', 'Anda bukan admin.');
                }
                $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
                return view('admin.dashboard', compact('recentOrders'));
            })->name('dashboard');

            // CRUD Produk
            Route::resource('products', ProductController::class);

            // Pesanan
            Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index');
            Route::patch('/orders/{id}', [OrderController::class, 'updateStatus'])->name('orders.update');
        });
});

require __DIR__.'/auth.php';
