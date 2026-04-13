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
    public function index(Request $request)
    {
        $query = Cart::where('user_id', Auth::id())
                     ->with('product.user');
        
        if ($request->has('selected_items')) {
            $query->whereIn('id', $request->selected_items);
        }
        
        $cartItems = $query->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Silahkan pilih minimal satu produk untuk di-checkout');
        }
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('buyer.checkout.index', compact('cartItems', 'subtotal'));
    }
    
    public function process(Request $request)
    {
        $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:transfer_bank,cod',
            'payment_proof' => 'required_if:payment_method,transfer_bank|image|mimes:jpeg,png,jpg|max:2048',
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:carts,id'
        ]);
        
        $cartItems = Cart::where('user_id', Auth::id())
                        ->whereIn('id', $request->selected_items)
                        ->with('product.user')
                        ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Produk pilihan tidak ditemukan atau sudah diproses');
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
                $file->storeAs('payments', $paymentProof, 'public');
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
            
            // Hapus item pilihan dari keranjang
            Cart::where('user_id', Auth::id())
                ->whereIn('id', $request->selected_items)
                ->delete();
            
            DB::commit();
            
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}