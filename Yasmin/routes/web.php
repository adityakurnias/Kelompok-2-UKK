<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AuthController,
    ProductController,
    CartController,
    OrderController,
    CheckoutController,
    ProfileController,
    BuyerController,
    SellerController,
    AdminController
};

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| BUYER ROUTES (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |-------------------
    | PROFILE
    |-------------------
    */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    });

    // Alias: route('profile') → profile.index
    Route::get('/profile-redirect', fn() => redirect()->route('profile.index'))->name('profile');

    /*
    |-------------------
    | BUYER DASHBOARD
    |-------------------
    */
    Route::get('/buyer/dashboard', [BuyerController::class, 'dashboard'])
        ->name('buyer.dashboard');

    /*
    |-------------------
    | CART
    |-------------------
    */
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/{cart}', [CartController::class, 'update'])->name('update');
        Route::delete('/{cart}', [CartController::class, 'remove'])->name('remove');
    });

    /*
    |-------------------
    | CHECKOUT
    |-------------------
    */
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    });

    /*
    |-------------------
    | ORDERS (Buyer)
    |-------------------
    */
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::put('/{id}/confirm', [OrderController::class, 'confirmReceipt'])->name('confirm');
        Route::put('/{id}/confirm', [OrderController::class, 'confirmReceipt'])->name('confirm-receipt'); // alias
        Route::put('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });

    /*
    |-------------------
    | SELLER REQUEST
    |-------------------
    */
    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/request', [SellerController::class, 'showRequestForm'])->name('request');
        Route::post('/request', [SellerController::class, 'submitRequest'])->name('request.submit');
        Route::get('/request-status', [SellerController::class, 'requestStatus'])->name('request-status');
    });
});


/*
|--------------------------------------------------------------------------
| SELLER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'checkRole:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        Route::get('/dashboard', [SellerController::class, 'dashboard'])
            ->name('dashboard');

        /*
        |-------------------
        | PRODUCTS (Seller)
        |-------------------
        */
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [SellerController::class, 'products'])->name('index');
            Route::get('/create', [SellerController::class, 'createProduct'])->name('create');
            Route::post('/', [SellerController::class, 'storeProduct'])->name('store');
            Route::get('/{product}/edit', [SellerController::class, 'editProduct'])->name('edit');
            Route::put('/{product}', [SellerController::class, 'updateProduct'])->name('update');
            Route::delete('/{product}', [SellerController::class, 'deleteProduct'])->name('delete'); // alias 'delete' bukan 'destroy'
        });

        /*
        |-------------------
        | ORDERS (Seller)
        |-------------------
        */
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [SellerController::class, 'orders'])->name('index');
            Route::put('/{order}/confirm', [SellerController::class, 'confirmOrder'])->name('confirm');
            Route::put('/{order}/ship', [SellerController::class, 'shipOrder'])->name('ship');
        });
    });

// Alias pendek untuk seller (supaya blade lama tetap jalan)
Route::middleware(['auth', 'checkRole:seller'])->group(function () {
    Route::get('/seller/products-list', fn() => redirect()->route('seller.products.index'))->name('seller.products');
    Route::get('/seller/orders-list', fn() => redirect()->route('seller.orders.index'))->name('seller.orders');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        /*
        |-------------------
        | USERS
        |-------------------
        */
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminController::class, 'users'])->name('index');
            Route::post('/', [AdminController::class, 'storeUser'])->name('store');
            Route::get('/{id}', [AdminController::class, 'userDetail'])->name('detail');
            Route::put('/{id}/block', [AdminController::class, 'blockUser'])->name('block');
            Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('delete');
        });

        /*
        |-------------------
        | CATEGORIES
        |-------------------
        */
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [AdminController::class, 'categories'])->name('index');
            Route::post('/', [AdminController::class, 'storeCategory'])->name('store');
            Route::put('/{category}', [AdminController::class, 'updateCategory'])->name('update');
            Route::delete('/{category}', [AdminController::class, 'deleteCategory'])->name('delete');
        });

        /*
        |-------------------
        | SELLER REQUESTS
        |-------------------
        */
        Route::prefix('seller-requests')->name('seller-requests.')->group(function () {
            Route::get('/', [AdminController::class, 'sellerRequests'])->name('index');
            Route::get('/{id}', [AdminController::class, 'sellerRequestDetail'])->name('detail');
            Route::put('/{id}/approve', [AdminController::class, 'approveSeller'])->name('approve');
            Route::put('/{id}/reject', [AdminController::class, 'rejectSeller'])->name('reject');
        });

        /*
        |-------------------
        | PRODUCT MODERATION
        |-------------------
        */
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/moderation', [AdminController::class, 'productModeration'])->name('moderation');
            Route::put('/{product}/approve', [AdminController::class, 'approveProduct'])->name('approve');
            Route::put('/{product}/reject', [AdminController::class, 'rejectProduct'])->name('reject');
            Route::delete('/{product}', [AdminController::class, 'deleteProduct'])->name('destroy');
        });

        /*
        |-------------------
        | ORDERS
        |-------------------
        */
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminController::class, 'orders'])->name('index');
            Route::get('/{order}', [AdminController::class, 'orderDetail'])->name('detail');
        });
    });

// Alias pendek untuk admin (supaya blade lama tetap jalan)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users-r', fn() => redirect()->route('admin.users.index'))->name('admin.users');
    Route::get('/admin/categories-r', fn() => redirect()->route('admin.categories.index'))->name('admin.categories');
    Route::get('/admin/seller-requests-r', fn() => redirect()->route('admin.seller-requests.index'))->name('admin.seller-requests');
    Route::get('/admin/orders-r', fn() => redirect()->route('admin.orders.index'))->name('admin.orders');
    Route::get('/admin/products-r', fn() => redirect()->route('admin.products.moderation'))->name('admin.products');

    // Alias untuk detail & aksi yang namanya berbeda
    Route::get('/admin/users/{id}', [AdminController::class, 'userDetail'])->name('admin.users.detail');
    Route::get('/admin/orders/{order}', [AdminController::class, 'orderDetail'])->name('admin.orders.detail');
    Route::get('/admin/seller-requests/{id}', [AdminController::class, 'sellerRequestDetail'])->name('admin.seller-requests.detail');
});