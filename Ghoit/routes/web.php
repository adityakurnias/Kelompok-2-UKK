<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::get('/debug-role', function() {
    return auth()->user()?->role ?? 'guest';
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/{transaction}/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/{transaction}/payment', [CheckoutController::class, 'uploadProof'])->name('checkout.upload-proof');
    Route::get('/checkout/{transaction}/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/transaction/{transaction}/invoice', [TransactionController::class, 'invoice'])->name('transaction.invoice');
    Route::post('/transaction/{transaction}/refund', [TransactionController::class, 'requestRefund'])->name('transaction.refund');
    Route::post('/transaction/{transaction}/complete', [TransactionController::class, 'completeTransaction'])->name('transaction.complete');
    
    // Fitur tambahan khusus user auth (bisa buyer)
    Route::get('/transaction/{transaction}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::post('/transaction/{transaction}/refund-received', [TransactionController::class, 'refundReceived'])->name('transaction.refund-received');
});

Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/dashboard', function () {
        $transactions = \App\Models\Transaction::where('user_id', auth()->id())
            ->whereNotIn('status', ['Diterima Pelanggan', 'Refund Selesai', 'Refund Ditolak']) // Dihapus dari UI user sesuai permintaan "ke hapus"
            ->latest()->get();
        return view('dashboard', compact('transactions'));
    })->name('dashboard');

    Route::get('/history', [TransactionController::class, 'history'])->name('history');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [TransactionController::class, 'dashboard'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/report', [TransactionController::class, 'report'])->name('transactions.report');
    Route::post('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.update-status');
    Route::post('/transactions/{transaction}/refund-respond', [TransactionController::class, 'respondRefund'])->name('transactions.refund-respond');
});

require __DIR__.'/auth.php';
