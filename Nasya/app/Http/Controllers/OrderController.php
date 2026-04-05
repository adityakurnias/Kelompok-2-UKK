<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Halaman Riwayat Pesanan User
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // Halaman Kelola Pesanan Admin
    public function adminIndex()
    {
        // Ambil semua order, urutkan dari yang terbaru
        $orders = Order::with(['user', 'items.product'])->latest()->get();

        // Mengarah ke resources/views/admin/index.blade.php
        return view('admin.index', compact('orders'));
    }

    // Aksi Update Status oleh Admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,success,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan #' . $id . ' berhasil diperbarui!');
    }
}