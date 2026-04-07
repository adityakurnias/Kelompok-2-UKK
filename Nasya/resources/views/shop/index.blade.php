<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl text-[#433422] leading-tight">
            {{ __('Koleksi Furniture Eksklusif') }}
        </h2>
    </x-slot>

    <style>
        .product-card-group:hover .admin-overlay {
            opacity: 1;
        }
        .admin-button {
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        .product-card-group:hover .admin-button {
            transform: translateY(0);
        }
    </style>

    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-8 p-4 bg-[#dcfce7] border-l-4 border-[#166534] text-[#166534] rounded-r-xl font-medium shadow-sm flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-12">
                <form action="{{ route('shop.index') }}" method="GET" class="relative max-w-3xl mx-auto">
                    <div class="flex items-center bg-white border border-[#eaddcf] rounded-2xl shadow-sm overflow-hidden focus-within:ring-2 focus-within:ring-[#78350f] transition-all">
                        <div class="pl-5 text-[#a16207]">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari kursi, meja, atau lemari impian Anda..."
                               class="w-full px-4 py-4 border-none focus:ring-0 text-[#433422] placeholder-[#8b7355] bg-transparent">

                        <button type="submit" class="bg-[#78350f] text-white px-8 py-4 font-bold hover:bg-[#433422] transition-colors">
                            CARI
                        </button>
                    </div>
                    @if(request('search'))
                        <p class="mt-3 text-sm text-[#8b7355] italic text-center">
                            Menampilkan hasil untuk: <span class="font-bold text-[#78350f]">"{{ request('search') }}"</span>
                            <a href="{{ route('shop.index') }}" class="text-[#78350f] underline ml-2">Hapus pencarian</a>
                        </p>
                    @endif
                </form>
            </div>

            <div class="flex flex-col lg:flex-row gap-10">
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <div class="bg-white border border-[#eaddcf] rounded-2xl p-6 sticky top-24">
                        <h3 class="font-serif text-xl text-[#433422] mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-[#78350f] rounded-full"></span>
                            Kategori
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('shop.index') }}"
                               class="block px-4 py-2 rounded-xl text-sm transition-all {{ !request('category') ? 'bg-[#78350f] text-white font-bold' : 'text-[#8b7355] hover:bg-[#fdf8f3] hover:text-[#78350f]' }}">
                                Semua Furniture
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('shop.index', ['category' => $category->slug, 'search' => request('search')]) }}"
                                   class="block px-4 py-2 rounded-xl text-sm transition-all {{ request('category') == $category->slug ? 'bg-[#78350f] text-white font-bold' : 'text-[#8b7355] hover:bg-[#fdf8f3] hover:text-[#78350f]' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <div class="flex-1">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                            @foreach($products as $product)
                                <div class="bg-white border border-[#eaddcf] rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group product-card-group relative">
                                    
                                    <div class="aspect-square overflow-hidden bg-[#fdf8f3] relative">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[#eaddcf]">
                                                <i class="fas fa-couch text-6xl"></i>
                                            </div>
                                        @endif

                                        @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                                        <div class="absolute inset-0 bg-black/20 opacity-0 admin-overlay transition-opacity duration-300 flex items-center justify-center gap-3">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                                               class="admin-button bg-white text-[#78350f] p-3 rounded-xl shadow-xl hover:bg-[#78350f] hover:text-white">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="m-0" onsubmit="return confirm('Hapus koleksi ini dari FurniSpace?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-button bg-white text-red-600 p-3 rounded-xl shadow-xl hover:bg-red-600 hover:text-white transition-delay-75">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endif

                                        <div class="absolute top-4 left-4 flex flex-wrap gap-1 pointer-events-none">
                                            @foreach($product->categories as $cat)
                                                <span class="bg-white/90 backdrop-blur-sm text-[#78350f] text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wider border border-[#eaddcf]">
                                                    {{ $cat->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <h3 class="font-serif text-xl text-[#433422] mb-2">{{ $product->name }}</h3>
                                        <p class="text-[#a16207] font-bold text-lg mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                                        <div class="flex items-center justify-between pt-4 border-t border-[#f3ede4]">
                                            <span class="text-[11px] text-[#8b7355] font-medium uppercase tracking-widest">Stok: {{ $product->stock }}</span>

                                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="bg-[#78350f] text-white p-3 rounded-xl hover:bg-[#433422] transition-all shadow-lg shadow-[#78350f]/20 active:scale-95">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white border border-[#eaddcf] rounded-3xl p-20 text-center">
                            <div class="w-20 h-20 bg-[#fdf8f3] rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-search text-[#eaddcf] text-3xl"></i>
                            </div>
                            <h3 class="font-serif text-2xl text-[#433422] mb-2">Produk Tidak Ditemukan</h3>
                            <p class="text-[#8b7355]">Maaf, kami tidak menemukan furniture yang sesuai di database <strong>ecommerce_db1</strong>.</p>
                            <a href="{{ route('shop.index') }}" class="inline-block mt-8 text-[#78350f] font-bold border-b-2 border-[#78350f]">
                                Kembali Lihat Semua Koleksi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>