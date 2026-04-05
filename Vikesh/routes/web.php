<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopController;

// 1. PUBLIC LANDING PAGE
Route::get('/', [LaptopController::class, 'index'])->name('catalogue');

// 2. DASHBOARD REDIRECT
Route::get('/dashboard', function () {
    $laptops = \App\Models\Laptop::all(); 
    return view('welcome', compact('laptops')); 
})->name('dashboard');

// 3. PROTECTED ROUTES (Login Required)
Route::middleware(['auth'])->group(function () {
    
    // ADMIN DASHBOARD & INVENTORY
    Route::get('/admin/dashboard', [LaptopController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/add', [LaptopController::class, 'create'])->name('admin.add');
    Route::post('/admin/laptop', [LaptopController::class, 'store'])->name('admin.store');
    Route::get('/admin/laptop/{id}/edit', [LaptopController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/laptop/{id}', [LaptopController::class, 'update'])->name('admin.update');
    Route::delete('/admin/laptop/{id}', [LaptopController::class, 'destroy'])->name('admin.destroy');
    
    // SHIPPING & ORDER MANAGEMENT
    Route::get('/admin/shipping', [LaptopController::class, 'manageShipping'])->name('admin.shipping');
    Route::patch('/admin/orders/{id}/status', [LaptopController::class, 'updateStatus'])->name('admin.order.status');
    
    // --- INI ADALAH FIX UNTUK ERROR ANDA ---
    Route::delete('/admin/orders/{id}', [LaptopController::class, 'deleteOrder'])->name('admin.order.delete');
    // ---------------------------------------

    // CUSTOMER FEATURES
    Route::get('/checkout/{id}', [LaptopController::class, 'checkout'])->name('checkout');
    Route::get('/my-orders', [LaptopController::class, 'userOrders'])->name('orders.index');
    Route::post('/place-order/{id}', [LaptopController::class, 'storeOrder'])->name('order.store');
});

require __DIR__.'/auth.php';