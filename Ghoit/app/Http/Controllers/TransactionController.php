<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function dashboard()
    {
        $totalTransactions = Transaction::count();
        $totalSales = Transaction::where('status', 'Selesai')->sum('total_price');
        $lowStockProducts = Product::where('stock', '<', 5)->get();
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalTransactions', 'totalSales', 'lowStockProducts', 'recentTransactions'));
    }

    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'items.product']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Pembayaran,Menunggu Konfirmasi,Diproses,Dikirim,Selesai'
        ]);

        $transaction->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui!');
    }
}
