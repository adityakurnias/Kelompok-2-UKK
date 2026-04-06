<x-app-layout>
    <style>
        .product-card { background: #1e293b; border-radius: 1.5rem; border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease; }
        .product-card:hover { border-color: #0ea5e9; box-shadow: 0 20px 40px rgba(14,165,233,0.1); transform: translateY(-6px); }
        .cat-pill { background: #1e293b; color: #94a3b8; border-radius: 9999px; transition: all 0.2s ease; }
        .cat-pill.active, .cat-pill:hover { background: #0ea5e9; color: white; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="py-12 bg-[#0f172a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Katalog <span class="text-sky-400">Perangkat Jaringan</span></h1>
                    <p class="text-slate-400 text-sm font-medium mt-1">Temukan perangkat networking terbaik untuk kebutuhanmu.</p>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="bg-sky-500 hover:bg-sky-400 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-sky-500/20 flex items-center gap-2">
                        <span>+</span> Tambah Perangkat
                    </a>
                @endif
            </div>

            <div class="flex gap-3 mb-10 overflow-x-auto pb-4 no-scrollbar">
                <a href="{{ route('products.index') }}" class="cat-pill whitespace-nowrap px-6 py-2 text-sm font-bold {{ !request('category') ? 'active' : '' }}">Semua Perangkat</a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="cat-pill whitespace-nowrap px-6 py-2 text-sm font-bold {{ request('category') == $cat->slug ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="product-card p-3 flex flex-col group">
                        <div class="relative aspect-square bg-slate-900 rounded-2xl mb-3 overflow-hidden flex items-center justify-center p-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 object-contain mx-auto group-hover:scale-110 transition-transform duration-300">
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="absolute inset-0 bg-black/70 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 backdrop-blur-sm">
                                    <a href="{{ route('products.edit', $product->id) }}" class="bg-amber-500 px-3 py-1.5 rounded-lg text-white text-xs font-bold hover:bg-amber-400 shadow-lg">✏️ Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus perangkat ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-600 px-3 py-1.5 rounded-lg text-white text-xs font-bold hover:bg-red-500 shadow-lg">🗑️ Hapus</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="px-2 flex-grow flex flex-col">
                            <p class="text-sky-400 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $product->category->name ?? 'Perangkat' }}</p>
                            <h3 class="text-white font-semibold text-sm line-clamp-2 mb-2 leading-tight">{{ $product->name }}</h3>
                            <p class="text-sky-300 font-bold text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full bg-sky-500/10 hover:bg-sky-500 border border-sky-500/30 hover:border-sky-500 text-sky-400 hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 text-sm">
                                + Keranjang
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            @if($products->isEmpty())
                <div class="text-center py-20">
                    <div class="text-5xl mb-4">📡</div>
                    <p class="text-slate-500 text-xl font-bold">Perangkat di kategori ini belum tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-white text-center md:text-left">Katalog Perangkat Jaringan</h1>
                
                {{-- TOMBOL KHUSUS ADMIN: Tambah Produk --}}
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition shadow-lg shadow-green-500/20">
                        + Tambah Perangkat
                    </a>
                @endif
            </div>

            <div class="flex gap-4 mb-10 overflow-x-auto pb-4 no-scrollbar">
                <a href="{{ route('products.index') }}" 
                   class="whitespace-nowrap px-6 py-2 {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-400' }} rounded-full text-sm font-medium transition hover:scale-105">
                    Semua Perangkat
                </a>
                {{-- Loop Kategori --}}
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" 
                       class="whitespace-nowrap px-6 py-2 {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-400' }} hover:bg-indigo-500 hover:text-white rounded-full text-sm font-medium transition hover:scale-105">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach($products as $product)
                    <div class="bg-gray-800 rounded-3xl p-3 border border-gray-700 hover:border-indigo-500 hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-300 group flex flex-col min-h-[22rem]">

                        {{-- Image Section --}}
                        <div class="relative aspect-square bg-gray-700 rounded-2xl mb-3 overflow-hidden flex items-center justify-center p-2">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-24 h-24 object-contain mx-auto group-hover:scale-110 transition-transform duration-300">
                            
                            {{-- OVERLAY ADMIN: Muncul saat hover kalau dia Admin --}}
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="absolute inset-0 bg-black/60 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 p-2 rounded-lg text-white hover:bg-yellow-400 shadow-lg">
                                        📝 Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus perangkat ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-600 p-2 rounded-lg text-white hover:bg-red-500 shadow-lg">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div class="px-2 flex-grow flex flex-col">
                            <p class="text-indigo-400 text-[10px] font-bold uppercase tracking-widest mb-1">
                                {{ $product->category->name ?? 'Perangkat' }}
                            </p>
                            <h3 class="text-white font-semibold text-sm line-clamp-2 mb-2 leading-tight">
                                {{ $product->name }}
                            </h3>
                            <p class="text-indigo-300 font-bold text-base">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Tombol Beli (Untuk Semua User) --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-white hover:text-indigo-600 text-white font-bold py-2 rounded-xl transition-all duration-300 text-sm flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Keranjang
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            @if($products->isEmpty())
                <div class="text-center py-20">
                    <p class="text-gray-500 text-xl">Yah, perangkat di kategori ini belum tersedia.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>