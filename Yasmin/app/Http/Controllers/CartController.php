<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Lihat keranjang
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
                        ->with('product.user')
                        ->get();
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('buyer.cart.index', compact('cartItems', 'subtotal'));
    }
    
    // Tambah ke keranjang
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        // Cek apakah produk tersedia
        if ($product->status != 'tersedia') {
            return back()->with('error', 'Produk tidak tersedia');
        }
        
        // Cek apakah sudah ada di keranjang
        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('product_id', $productId)
                            ->first();
        
        if ($existingCart) {
            // Update quantity
            $existingCart->update([
                'quantity' => $existingCart->quantity + 1
            ]);
        } else {
            // Tambah baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }
    
    // Update quantity
    public function update(Request $request, Cart $cart)
    {
        // Pastikan cart milik user yang login
        if ($cart->user_id != Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart->update([
            'quantity' => $request->quantity
        ]);
        
        return back()->with('success', 'Keranjang berhasil diupdate');
    }
    
    // Hapus dari keranjang
    public function remove(Cart $cart)
    {
        if ($cart->user_id != Auth::id()) {
            abort(403);
        }
        
        $cart->delete();
        
        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}