<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Keranjang Anda - Toko ATK</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
    </head>
    <body class="antialiased bg-[#fdfdfd] text-gray-900">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Kembali ke Toko</span>
                    </a>
                    <span class="text-xl font-extrabold tracking-tighter text-blue-900">ATK<span class="text-blue-500">Cart</span></span>
                </div>
            </div>
        </nav>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl font-black text-gray-900 tracking-tight mb-12">Keranjang Belanja</h1>

            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl text-sm font-bold flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(count($cart) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Items -->
                    <div class="lg:col-span-2 space-y-6">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="flex items-center bg-white border border-gray-100 p-6 rounded-[2rem] hover:shadow-xl hover:shadow-gray-100/50 transition-all group">
                                <div class="w-24 h-24 bg-gray-50 rounded-2xl flex-shrink-0 overflow-hidden border border-gray-50 relative">
                                     @if($details['image'])
                                        <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                     @else
                                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-blue-50">
                                            <svg class="w-8 h-8 text-blue-100 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                     @endif
                                </div>
                                <div class="ml-6 flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $details['name'] }}</h3>
                                    <p class="text-blue-600 font-black text-sm mt-1 tracking-tight">Rp {{ number_format($details['price'], 0, ',', '.') }}</p>

                                    <div class="mt-4 flex items-center justify-between">
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center bg-gray-50 rounded-xl px-2">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" name="quantity" value="{{ $details['quantity'] - 1 }}" class="p-2 text-gray-400 hover:text-blue-600 transition-colors" {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                            <span class="px-4 text-sm font-black text-gray-900 tabular-nums">{{ $details['quantity'] }}</span>
                                            <button type="submit" name="quantity" value="{{ $details['quantity'] + 1 }}" class="p-2 text-gray-400 hover:text-blue-600 transition-colors">+</button>
                                        </form>

                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-500 uppercase tracking-widest transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white sticky top-28 shadow-2xl shadow-gray-900/20">
                            <h2 class="text-2xl font-black tracking-tight mb-8">Ringkasan</h2>
                            <div class="space-y-4 border-b border-white/10 pb-8 mb-8">
                                <div class="flex justify-between text-gray-400 text-[10px] font-black uppercase tracking-widest">
                                    <span>Subtotal</span>
                                    <span class="text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-400 text-[10px] font-black uppercase tracking-widest">
                                    <span>Pengiriman</span>
                                    <span class="text-green-400">Dihitung nanti</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-end mb-10">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Harga</span>
                                <span class="text-3xl font-black text-white tracking-tighter tabular-nums">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full py-5 bg-blue-600 text-white text-center rounded-2xl font-bold tracking-tight shadow-xl shadow-blue-600/20 hover:bg-blue-500 hover:-translate-y-1 transition-all active:scale-95">
                                Checkout Sekarang
                            </a>
                            <p class="mt-6 text-[9px] text-center text-gray-500 font-bold uppercase tracking-[0.2em] leading-relaxed">
                                Tanpa kartu kredit. <br> Pengisian biodata saja.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="py-24 text-center bg-white rounded-[4rem] border border-dashed border-gray-100">
                    <div class="inline-flex p-8 bg-gray-50 rounded-full mb-6">
                        <svg class="w-16 h-16 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Keranjang Anda kosong</h2>
                    <p class="text-gray-400 mt-2 font-medium">Sepertinya Anda belum menambahkan produk ATK apapun.</p>
                    <a href="{{ route('home') }}" class="mt-10 inline-block bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold shadow-xl shadow-blue-600/20 hover:bg-blue-700 transition-all active:scale-95">Mulai Belanja</a>
                </div>
            @endif
        </div>
    </body>
</html>
