<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja Anda kosong');
        }
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:Transfer Bank,QRIS,COD',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja Anda kosong');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'status' => $request->payment_method === 'COD' ? 'Diproses' : 'Menunggu Pembayaran',
                'total_price' => $totalPrice,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_email' => $request->shipping_email,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($cart as $id => $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update stock
                $product = \App\Models\Product::find($id);
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            if ($request->payment_method === 'COD') {
                return redirect()->route('checkout.success', $transaction);
            }

            return redirect()->route('checkout.payment', $transaction)->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function payment(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transaction->status !== 'Menunggu Pembayaran') {
            return redirect()->route('dashboard')->with('info', 'Transaksi ini sudah atau sedang diproses.');
        }

        return view('checkout.payment', compact('transaction'));
    }

    public function uploadProof(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $transaction->update([
                'payment_proof' => $path,
                'status' => 'Menunggu Konfirmasi'
            ]);

            return redirect()->route('checkout.success', $transaction);
        }

        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }

    public function success(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('transaction'));
    }
}
