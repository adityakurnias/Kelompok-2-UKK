<?php
// app/Http/Controllers/BuyerController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik pesanan
        $totalOrders = Order::where('buyer_id', $user->id)->count();
        $pendingOrders = Order::where('buyer_id', $user->id)
                            ->where('status', 'pending')
                            ->count();
        $shippedOrders = Order::where('buyer_id', $user->id)
                            ->where('status', 'shipped')
                            ->count();
        $completedOrders = Order::where('buyer_id', $user->id)
                            ->where('status', 'completed')
                            ->count();
        
        // Keranjang
        $cartItems = Cart::where('user_id', $user->id)
                        ->with('product')
                        ->get();
        $cartTotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        $cartCount = $cartItems->count();
        
        // Pesanan terbaru (5 data)
        $recentOrders = Order::where('buyer_id', $user->id)
                            ->with('items.product')
                            ->latest()
                            ->take(5)
                            ->get();
        
        // Produk rekomendasi (random)
        $recommendedProducts = Product::where('status', 'tersedia')
                                    ->with('user')
                                    ->inRandomOrder()
                                    ->take(8)
                                    ->get();
        
        // Kategori favorit (dari riwayat pesanan)
        $favoriteCategories = Order::where('buyer_id', $user->id)
                                ->with('items.product.category')
                                ->get()
                                ->pluck('items')
                                ->flatten()
                                ->pluck('product.category_id')
                                ->unique()
                                ->take(3);
        
        return view('buyer.dashboard', compact(
            'user',
            'totalOrders',
            'pendingOrders',
            'shippedOrders',
            'completedOrders',
            'cartItems',
            'cartTotal',
            'cartCount',
            'recentOrders',
            'recommendedProducts',
            'favoriteCategories'
        ));
    }
}