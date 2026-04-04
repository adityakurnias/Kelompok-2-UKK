<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
                        ->with('product.user')
                        ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong');
        }
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('buyer.checkout.index', compact('cartItems', 'subtotal'));
    }
    
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:transfer_bank,cod',
            'payment_proof' => 'required_if:payment_method,transfer_bank|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $cartItems = Cart::where('user_id', Auth::id())
                        ->with('product.user')
                        ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong');
        }
        
        DB::beginTransaction();
        
        try {
            // Buat order number
            $orderNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(8));
            
            // Hitung total
            $totalPrice = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            
            // Upload bukti bayar jika transfer bank
            $paymentProof = null;
            if ($request->payment_method == 'transfer_bank' && $request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $paymentProof = time() . '.' . $file->extension();
                $file->storeAs('public/payments', $paymentProof);
            }
            
            // Buat order
            $order = Order::create([
                'order_number' => $orderNumber,
                'buyer_id' => Auth::id(),
                'total_price' => $totalPrice,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'payment_proof' => $paymentProof,
                'status' => 'pending'
            ]);
            
            // Buat order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'seller_id' => $item->product->user_id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity
                ]);
                
                // Update status produk (opsional, bisa jadi terjual nanti)
                // $item->product->update(['status' => 'terjual']);
            }
            
            // Hapus keranjang
            Cart::where('user_id', Auth::id())->delete();
            
            DB::commit();
            
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}