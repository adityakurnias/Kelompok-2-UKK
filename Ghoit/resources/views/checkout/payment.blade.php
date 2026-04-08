<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Pesanan - Toko ATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="antialiased bg-[#fdfdfd] text-gray-900">
    <nav class="bg-white border-b border-gray-100 h-20 flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between items-center">
            <span class="text-xl font-extrabold tracking-tighter text-blue-900 leading-none">ATK<span class="text-blue-500">Checkout</span></span>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">Step 2: Pembayaran</span>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-[3rem] border border-gray-100 p-8 sm:p-12 shadow-2xl shadow-gray-200/50">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Selesaikan Pembayaran</h1>
                <p class="text-gray-500 font-medium mt-2">Batas waktu pembayaran 1x24 jam.</p>
            </div>

            <div class="bg-blue-50/50 rounded-3xl p-6 border border-blue-100/50 mb-10 text-center">
                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1 block">Total Tagihan</span>
                <span class="text-4xl font-black text-blue-600 tracking-tighter">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
            </div>

            @if($transaction->payment_method === 'QRIS')
                <div class="flex flex-col items-center mb-10">
                    <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full mb-6">Metode: QRIS</span>
                    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/50 w-72 flex flex-col items-center justify-center relative overflow-hidden group hover:border-blue-500 transition-all">
                        <!-- Dynamic QR Code - Scannable -->
                        <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-50 mb-4 group-hover:scale-105 transition-transform duration-300">
                            <!-- Generate Real QR using API: When scanned, it reads the transaction details (or points to a WA link) -->
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ urlencode('wa.me/6281234567890?text=Halo+saya+ingin+bayar+pesanan+ID+#' . $transaction->id . '+sebesar+Rp' . number_format($transaction->total_price, 0)) }}" alt="QRIS Dinamis" class="w-48 h-48 object-contain">
                        </div>
                        <div class="text-center w-full bg-blue-50/50 rounded-xl p-3 border border-blue-50">
                            <span class="font-black text-lg text-gray-900 tracking-tighter block mb-0.5">QRIS ATK STORE</span>
                            <span class="text-[9px] text-blue-600 uppercase tracking-widest font-bold flex items-center justify-center">
                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                Silakan Scan Kode
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center mb-10 text-center">
                    <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full mb-6">Metode: Transfer Bank</span>
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 w-full max-w-sm">
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1 block">Bank BCA</span>
                        <span class="text-2xl font-black text-gray-900 tracking-tighter block mb-1">123-456-7890</span>
                        <span class="text-sm font-semibold text-gray-500 block">a.n ATK Store Indonesia</span>
                    </div>
                </div>
            @endif

            <hr class="border-gray-100 border-dashed my-10">

            <form action="{{ route('checkout.upload-proof', $transaction) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Upload Bukti Pembayaran</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-3xl hover:border-blue-500 hover:bg-blue-50/50 transition-all group relative">
                        <div class="space-y-1 text-center w-full">
                            <svg class="mx-auto h-12 w-12 text-gray-300 group-hover:text-blue-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center w-full mt-4">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <input id="file-upload" name="payment_proof" type="file" class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100 cursor-pointer" accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">PNG, JPG, JPEG up to 2MB</p>
                        </div>
                    </div>
                    @error('payment_proof') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white rounded-[2rem] font-bold tracking-tight shadow-2xl shadow-blue-600/30 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 text-lg">
                        Konfirmasi Pembayaran
                    </button>
                    <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">Bayar Nanti (Kembali ke Dashboard)</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
