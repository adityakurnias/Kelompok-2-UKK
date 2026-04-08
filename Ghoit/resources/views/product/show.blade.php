<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $product->name }} - ATK Ghoits</title>
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

                    <!-- Search (Hidden on detail page but kept for structure or search functionality if needed) -->
                    <div class="hidden md:block flex-1 max-w-md mx-8">
                        <form action="{{ route('home') }}" method="GET" class="relative group">
                            <input type="text" name="search"
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
            </div>
        </nav>

        <!-- Product Detail Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
            <!-- Breadcrumb -->
            <nav class="mb-8 flex py-3 px-5 text-gray-700 rounded-2xl bg-white border border-gray-100/60 shadow-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('home', ['category' => $product->category_id]) }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 md:ml-2">{{ $product->category->name }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-bold text-gray-800 md:ml-2">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-[2rem] border border-gray-100/60 p-6 md:p-10 shadow-xl shadow-gray-200/20">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
                    <!-- Image -->
                    <div class="aspect-square bg-gray-50 rounded-[2rem] overflow-hidden relative shadow-inner">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-blue-50">
                                <svg class="w-24 h-24 text-blue-100 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-black uppercase tracking-widest text-blue-200">Foto Segera Hadir</span>
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="flex flex-col justify-center">
                        <div class="inline-block px-4 py-2 rounded-xl bg-blue-50 text-blue-600 text-xs font-black uppercase tracking-widest mb-6 w-max border border-blue-100">
                            {{ $product->category->name }}
                        </div>

                        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight mb-4">
                            {{ $product->name }}
                        </h1>

                        <div class="text-3xl md:text-4xl font-black text-blue-600 tracking-tighter mb-8">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        <div class="prose prose-blue prose-lg text-gray-500 mb-10 leading-relaxed">
                            <p>{{ $product->description }}</p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 mb-10 flex justify-between items-center">
                            <div>
                                <span class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Status Stok</span>
                                <span class="text-lg font-bold @if($product->stock > 10) text-green-500 @elseif($product->stock > 0) text-orange-500 @else text-red-500 @endif flex items-center">
                                    @if($product->stock > 0)
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Tersedia ({{ $product->stock }} item)
                                    @else
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Habis
                                    @endif
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" 
                                class="w-full py-5 bg-gray-900 text-white rounded-2xl font-bold text-lg tracking-tight hover:bg-blue-600 hover:shadow-2xl hover:shadow-blue-500/40 transition-all active:scale-[0.98] flex justify-center items-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-gray-900 disabled:hover:shadow-none"
                                @if($product->stock <= 0) disabled @endif>
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ $product->stock > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-16 mt-12">
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
