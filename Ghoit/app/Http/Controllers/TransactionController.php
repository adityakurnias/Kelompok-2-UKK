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

    public function invoice(Transaction $transaction)
    {
        if ($transaction->user_id !== \Illuminate\Support\Facades\Auth::id() && \Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('checkout.invoice', compact('transaction'));
    }

    public function report()
    {
        $transactions = Transaction::with(['user', 'items.product'])->latest()->get();
        if(request()->has('pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.transactions.report', compact('transactions'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('Laporan_Penjualan_ATK_Ghoits_'.date('Ymd_Hi').'.pdf');
        }
        return view('admin.transactions.report', compact('transactions'));
    }

    public function requestRefund(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        if ($transaction->status !== 'Selesai') {
            return redirect()->back()->with('error', 'Refund hanya dapat diajukan pada pesanan yang sudah selesai.');
        }

        $request->validate([
            'refund_reason' => 'required|string|min:5'
        ]);

        $transaction->update([
            'refund_status' => 'pending',
            'refund_reason' => $request->refund_reason
        ]);

        return redirect()->back()->with('success', 'Permintaan refund berhasil diajukan. Admin akan segera memproses.');
    }

    public function respondRefund(Request $request, Transaction $transaction)
    {
        $request->validate([
            'refund_action' => 'required|in:accept,reject'
        ]);

        if ($request->refund_action === 'accept') {
            $transaction->update([
                'refund_status' => 'accepted',
                'status' => 'Refund Diterima'
            ]);

            // Restore stock
            foreach ($transaction->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            return redirect()->back()->with('success', 'Refund diterima dan stok dikembalikan.');
        } else {
            $transaction->update([
                'refund_status' => 'rejected',
                'status' => 'Refund Ditolak'
            ]);
            return redirect()->back()->with('success', 'Refund ditolak.');
        }
    }

    public function completeTransaction(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $transaction->update([
            'status' => 'Diterima Pelanggan'
        ]);

        return redirect()->back()->with('success', 'Pesanan telah diselesaikan. Meneruskan notifikasi ke Admin.');
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== \Illuminate\Support\Facades\Auth::id() && \Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('transaction.show', compact('transaction'));
    }

    public function refundReceived(Transaction $transaction)
    {
        if ($transaction->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        if ($transaction->refund_status !== 'accepted') {
            return redirect()->back()->with('error', 'Refund belum disetujui admin.');
        }

        $transaction->update([
            'status' => 'Refund Selesai',
            'refund_status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Uang telah diterima dan transaksi selesai direfund.');
    }

    public function history()
    {
        $transactions = Transaction::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->whereIn('status', ['Diterima Pelanggan', 'Refund Selesai', 'Refund Ditolak'])
            ->latest()
            ->get();
            
        return view('history', compact('transactions'));
    }
}
