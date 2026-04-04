<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', Auth::id())
                      ->with('items.product')
                      ->latest()
                      ->paginate(10);
        
        return view('buyer.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::where('buyer_id', Auth::id())
                     ->with('items.product.user')
                     ->findOrFail($id);
        
        return view('buyer.orders.show', compact('order'));
    }
    
    public function confirmReceipt($id)
    {
        $order = Order::where('buyer_id', Auth::id())->findOrFail($id);
        
        if ($order->status != 'shipped') {
            return back()->with('error', 'Pesanan belum dikirim');
        }
        
        $order->update(['status' => 'completed']);
        
        return back()->with('success', 'Penerimaan barang dikonfirmasi');
    }
    
    public function cancel($id)
    {
        $order = Order::where('buyer_id', Auth::id())->findOrFail($id);
        
        if ($order->status != 'pending') {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan');
        }
        
        $order->update(['status' => 'cancelled']);
        
        return back()->with('success', 'Pesanan dibatalkan');
    }
}