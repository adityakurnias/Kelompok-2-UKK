<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Checkout - Toko ATK</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
    </head>
    <body class="antialiased bg-[#fdfdfd] text-gray-900">
        <nav class="bg-white border-b border-gray-100 h-20 flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between items-center">
                <a href="{{ route('cart.index') }}" class="flex items-center space-x-2 group">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest group-hover:text-gray-600 transition-colors">Kembali ke Keranjang</span>
                </a>
                <span class="text-xl font-extrabold tracking-tighter text-blue-900 leading-none">ATK<span class="text-blue-500">Checkout</span></span>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">
                <!-- Form -->
                <div>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight mb-4">Lengkapi Pengiriman</h1>
                    <p class="text-gray-500 font-medium mb-12">Mohon berikan detail Anda untuk pengiriman. Tidak ada pembayaran yang diperlukan saat ini.</p>

                    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Nama Lengkap</label>
                                <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required
                                    class="w-full bg-white border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                                @error('shipping_name') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Nomor WhatsApp/HP</label>
                                    <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" required placeholder="Contoh: 08123456789"
                                        class="w-full bg-white border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                                    @error('shipping_phone') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Alamat Email</label>
                                    <input type="email" name="shipping_email" value="{{ old('shipping_email', auth()->user()->email) }}" required
                                        class="w-full bg-white border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                                    @error('shipping_email') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Alamat Lengkap Pengiriman</label>
                                <textarea name="shipping_address" rows="4" required placeholder="Alamat lengkap termasuk kota dan kode pos"
                                    class="w-full bg-white border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all resize-none">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full py-5 bg-blue-600 text-white rounded-[2rem] font-bold tracking-tight shadow-2xl shadow-blue-600/30 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 text-lg">
                                Konfirmasi & Kirim Pesanan
                            </button>
                            <p class="mt-6 text-center text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-relaxed">
                                Dengan menekan tombol, <br> pesanan Anda akan dikirim ke admin untuk diproses.
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Order Preview -->
                <div class="hidden lg:block bg-blue-50/30 rounded-[4rem] p-12 h-fit border border-blue-100/30 shadow-sm">
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight mb-10">Ringkasan Pesanan</h2>
                    <div class="space-y-6 max-h-[400px] overflow-y-auto pr-4 custom-scrollbar">
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php $total += $item['price'] * $item['quantity'] @endphp
                            <div class="flex items-center">
                                <div class="w-16 h-16 bg-white rounded-2xl flex-shrink-0 border border-blue-100/50 overflow-hidden shadow-sm">
                                     @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                                     @else
                                        <div class="w-full h-full flex items-center justify-center text-blue-100 bg-gradient-to-br from-white to-blue-50">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </div>
                                     @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-sm font-bold text-gray-900 leading-tight">{{ $item['name'] }}</h4>
                                    <p class="text-xs text-blue-500 font-black mt-1">x{{ $item['quantity'] }} • Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                <span class="text-sm font-black text-gray-900 tabular-nums">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12 pt-8 border-t-2 border-dashed border-blue-200">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Subtotal</span>
                            <span class="text-sm font-black text-gray-900 tabular-nums">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-8">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ongkos Kirim</span>
                            <span class="text-[10px] font-black text-green-600 uppercase tracking-widest bg-green-50 px-2 py-1 rounded-lg">Dihitung Nanti</span>
                        </div>
                        <div class="flex justify-between items-end">
                            <span class="text-sm font-black text-gray-900 uppercase tracking-tighter">Total Bayar</span>
                            <span class="text-3xl font-black text-blue-600 tracking-tighter tabular-nums">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-12 p-6 bg-white/60 backdrop-blur-sm rounded-3xl border border-blue-100 flex items-start space-x-4">
                        <div class="bg-blue-100 p-3 rounded-2xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-gray-900 mb-1 leading-none">Catatan Pembayaran</h5>
                            <p class="text-[11px] text-gray-400 font-medium leading-relaxed">Admin akan menghubungi Anda melalui WhatsApp atau Email untuk konfirmasi pembayaran setelah pesanan diproses.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #dbeafe; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #bfdbfe; }
        </style>
    </body>
</html>
