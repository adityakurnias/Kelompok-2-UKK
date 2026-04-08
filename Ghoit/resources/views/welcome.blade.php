<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Toko ATK Ghoits - Peralatan Kantor Premium Anda</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: white;
                background-image:
                    linear-gradient(#f0f0f0 1px, transparent 1px),
                    linear-gradient(90deg, #f0f0f0 1px, transparent 1px);
                background-size: 30px 30px;
            }
        </style>
    </head>
    <body class="antialiased bg-[#fdfdfd] text-gray-900">
        <!-- Navbar -->
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex flex-col">
                            <span class="text-2xl font-extrabold tracking-tighter text-blue-900 leading-none"><span class="rgb-glow-text">ATK Ghoits</span></span>
                            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mt-1">Kualitas Premium</span>
                        </a>
                    </div>

                    <!-- Search -->
                    <div class="hidden md:block flex-1 max-w-md mx-8">
                        <form action="{{ route('home') }}" method="GET" class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3 px-12 text-sm focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300"
                                placeholder="Cari pulpen, kertas, kalkulator...">
                            <svg class="absolute left-4 top-3.5 h-4 w-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </form>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="bg-gray-50 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 border border-gray-100 transition-all shadow-sm">Dashboard</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="bg-gray-50 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 border border-gray-100 transition-all shadow-sm">Dashboard</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                                @csrf
                                <button type="submit" class="bg-red-50/80 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-100 border border-red-100 transition-all shadow-sm">Keluar</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-gray-50 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 border border-gray-100 transition-all shadow-sm">Masuk</a>
                            <a href="{{ route('register') }}" class="text-xs sm:text-sm font-bold bg-blue-600 text-white px-3.5 py-2 rounded-xl shadow-sm shadow-blue-500/20 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">Daftar</a>
                        @endauth

                        <a href="{{ route('cart.index') }}" class="relative group block">
                            <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100 group-hover:bg-blue-50 group-hover:border-blue-100 transition-all shadow-sm group-hover:-translate-y-0.5">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-600 group-hover:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[9px] sm:text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white shadow-sm">
                                {{ count(session('cart', [])) }}
                            </span>
                        </a>
                    </div>
                </div>
                <!-- Mobile Search Bar -->
                <div class="md:hidden pb-4">
                    <form action="{{ route('home') }}" method="GET" class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-2.5 px-10 text-sm focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all" placeholder="Cari produk...">
                        <svg class="absolute left-3.5 top-3 h-4 w-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative overflow-hidden pt-12 pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center">
                    <h1 class="text-5xl sm:text-7xl font-extrabold text-gray-900 tracking-tight leading-none">
                        Tingkatkan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Produktivitas</span> Anda
                    </h1>
                    <p class="mt-6 text-xl text-gray-500 max-w-2xl mx-auto font-medium">
                        Peralatan kantor profesional untuk para pemikir dan pekerja modern. Sederhana, premium, dan dirancang untuk fokus.
                    </p>
                </div>

                <!-- Category Filters -->
                <div class="mt-16 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('home') }}"
                        class="px-6 py-3 rounded-2xl text-sm font-bold transition-all {{ !request('category') ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/20' : 'bg-white text-gray-500 border border-gray-100 hover:border-blue-500 hover:text-blue-600' }}">
                        Semua Produk
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('home', ['category' => $category->id] + request()->except('category', 'page')) }}"
                            class="px-6 py-3 rounded-2xl text-sm font-bold transition-all {{ request('category') == $category->id ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/20' : 'bg-white text-gray-500 border border-gray-100 hover:border-blue-500 hover:text-blue-600' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Abstract background shapes -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full pointer-events-none opacity-40">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-100 rounded-full blur-[120px] -mr-[300px] -mt-[100px]"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-indigo-50 rounded-full blur-[100px] -ml-[250px] -mb-[100px]"></div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($products as $product)
                    <div class="group relative bg-white rounded-[2rem] border border-gray-100/60 p-5 hover:shadow-2xl hover:shadow-gray-200/50 hover:-translate-y-2 transition-all duration-300">
                        <!-- Product Image -->
                        <a href="{{ route('product.show', $product->id) }}" class="block">
                            <div class="aspect-square bg-gray-50 rounded-[1.5rem] mb-4 overflow-hidden relative">
                                 @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                 @else
                                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-blue-50">
                                        <svg class="w-12 h-12 text-blue-100 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-[8px] font-black uppercase tracking-widest text-blue-200">Foto Segera Hadir</span>
                                    </div>
                                 @endif

                                 <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-blue-600 shadow-sm">
                                    {{ $product->category->name }}
                                 </div>
                            </div>
                        </a>

                        <div class="px-2">
                            <a href="{{ route('product.show', $product->id) }}" class="block">
                                <h3 class="text-lg font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition-colors line-clamp-1">{{ $product->name }}</h3>
                            </a>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter mb-1">Harga</span>
                                    <span class="text-xl font-black text-blue-600 tracking-tighter">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter mb-1">Stok</span>
                                    <span class="text-sm font-bold @if($product->stock > 10) text-green-500 @else text-orange-500 @endif">
                                        {{ $product->stock }} <span class="text-[10px] opacity-70">pcs</span>
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('product.show', $product->id) }}" class="mt-6 block w-full py-3 text-center border-2 border-gray-100 text-gray-700 rounded-2xl font-bold tracking-tight hover:bg-blue-600 hover:border-blue-600 hover:text-white hover:shadow-xl hover:shadow-blue-500/30 transition-all active:scale-[0.98]">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center bg-white rounded-[3rem] border border-dashed border-gray-100">
                        <div class="inline-flex p-8 bg-gray-50 rounded-full mb-6">
                            <svg class="w-16 h-16 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">Produk tidak ditemukan</h3>
                        <p class="text-gray-400 mt-2 font-medium">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                        <a href="{{ route('home') }}" class="mt-10 inline-block font-bold text-blue-600 hover:underline decoration-2 underline-offset-8">Kembali ke semua produk</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $products->links() }}
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
                <div class="flex flex-col items-center mb-8">
                    <span class="text-2xl font-extrabold tracking-tighter text-blue-900 leading-none text-center"><span class="rgb-glow-text">ATK Ghoits</span></span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mt-2">Peralatan Kantor Premium</span>
                </div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">© {{ date('Y') }} ATK Ghoits Indonesia. Melayani dengan Sepenuh Hati.</p>
            </div>
        </footer>
    </body>
</html>
