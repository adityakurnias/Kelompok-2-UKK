<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen text-[#433422]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Debug Info --}}
            @if(auth()->check())
                <div class="mb-4 p-2 bg-gray-800 text-white text-[10px] rounded-lg">
                    Login sebagai: {{ auth()->user()->email }} | Role: {{ auth()->user()->role }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">

               {{-- SIDEBAR KATEGORI --}}
                    <div class="w-full lg:w-1/4">
                        <div class="bg-white rounded-[2rem] p-8 border border-[#eaddcf] shadow-sm sticky top-24">
                            <h2 class="text-xl font-bold mb-6 flex items-center gap-2" style="font-family: 'Playfair Display', serif;">
                                <span class="w-1.5 h-6 bg-[#78350f] rounded-full"></span>
                                Kategori
                            </h2>

                            <div class="flex flex-col gap-2">
                                @php
                                    $baseRoute = (auth()->check() && strtolower(auth()->user()->role) === 'admin') ? 'admin.products.index' : 'products.index';

                                    // Daftar kategori baru sesuai permintaan Anda
                                    $customCategories = [
                                        ['name' => 'Ruang Tamu', 'slug' => 'ruang-tamu'],
                                        ['name' => 'Kamar Tidur', 'slug' => 'kamar-tidur'],
                                        ['name' => 'Ruang Keluarga', 'slug' => 'ruang-keluarga'],
                                        ['name' => 'Ruang Makan', 'slug' => 'ruang-makan'],
                                        ['name' => 'Ruang Kerja', 'slug' => 'ruang-kerja'],
                                        ['name' => 'Kamar Mandi', 'slug' => 'kamar-mandi'],
                                        ['name' => 'Luar Ruangan', 'slug' => 'luar-ruangan'],
                                    ];
                                @endphp

                                {{-- Button Semua Furniture --}}
                                <a href="{{ route($baseRoute) }}"
                                class="px-5 py-3 rounded-2xl text-sm font-bold transition-all {{ !request('category') ? 'bg-[#78350f] text-white' : 'hover:bg-[#fef3c7] text-[#7d6e5d]' }}">
                                    Semua Furniture
                                </a>

                                {{-- Looping Kategori Baru --}}
                                @foreach($customCategories as $cat)
                                    <a href="{{ route($baseRoute, ['category' => $cat['slug']]) }}"
                                    class="px-5 py-3 rounded-2xl text-sm font-bold transition-all {{ request('category') == $cat['slug'] ? 'bg-[#78350f] text-white' : 'hover:bg-[#fef3c7] text-[#7d6e5d]' }}">
                                        {{ $cat['name'] }}
                                    </a>
                                @endforeach
                            </div>

                            {{-- Tombol Tambah Produk khusus Admin --}}
                            @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                                <div class="mt-8 pt-8 border-t border-[#eaddcf]">
                                    <a href="{{ route('admin.products.create') }}" class="w-full inline-flex justify-center items-center px-4 py-3 bg-[#78350f] text-white text-xs font-bold rounded-xl hover:bg-[#451a03] transition-all uppercase tracking-widest shadow-md">
                                        + Tambah Produk
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                {{-- MAIN CONTENT --}}
                <div class="w-full lg:w-3/4">
                    {{-- Search Bar --}}
                    <div class="mb-10 relative">
                        <form action="{{ route((auth()->check() && strtolower(auth()->user()->role) === 'admin') ? 'admin.products.index' : 'products.index') }}" method="GET" class="flex gap-0 shadow-xl shadow-[#78350f]/5 rounded-2xl overflow-hidden border-2 border-[#eaddcf] focus-within:border-[#78350f] transition-all">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kursi, meja, atau lemari impian Anda..."
                                   class="w-full border-none px-6 py-4 focus:ring-0 text-sm placeholder:text-[#eaddcf]">
                            <button type="submit" class="bg-[#78350f] text-white px-10 font-bold text-xs uppercase tracking-widest hover:bg-[#451a03] transition-colors">
                                Cari
                            </button>
                        </form>
                    </div>

                    {{-- Grid Produk --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="group bg-white border border-[#eaddcf] rounded-[2rem] p-4 flex flex-col hover:shadow-2xl transition-all duration-500 relative">

                                {{-- Image Container --}}
                                <div class="relative aspect-square overflow-hidden rounded-[1.5rem] bg-[#F9F7F2] mb-4">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                                    {{-- Badges Kategori --}}
                                    <div class="absolute top-3 left-3 flex flex-wrap gap-1">
                                        @foreach($product->categories as $cat)
                                            <span class="bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-[8px] font-black text-[#78350f] uppercase border border-[#eaddcf]">
                                                {{ $cat->name }}
                                            </span>
                                        @endforeach
                                    </div>

                                    {{-- TOMBOL ADMIN (EDIT & DELETE) --}}
                                @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                                    {{-- Hapus opacity-0 dan animasi group-hover agar tombol selalu terlihat --}}
                                    <div class="absolute top-3 right-3 flex flex-col gap-2 z-50 transition-all duration-300">

                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 bg-white text-[#78350f] rounded-xl shadow-lg border border-[#eaddcf] hover:bg-[#fef3c7] transition-transform active:scale-90">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk {{ $product->name }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-white text-red-600 rounded-xl shadow-lg border border-[#eaddcf] hover:bg-red-50 transition-transform active:scale-90">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                                </div>

                                {{-- Info Produk --}}
                                <div class="px-2 pb-2">
                                    <h3 class="text-[#433422] font-bold text-lg mb-1 capitalize" style="font-family: 'Playfair Display', serif;">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-[#78350f] font-black text-lg mb-3">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-[#f9f7f2]">
                                        <span class="text-[10px] text-[#a16207] font-bold uppercase tracking-widest">Stok: {{ $product->stock }}</span>

                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-[#78350f] text-white p-2.5 rounded-xl hover:bg-[#451a03] transition-all active:scale-90">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-20 text-center bg-white rounded-[2rem] border border-[#eaddcf]">
                                <p class="font-bold text-[#7d6e5d]">Produk tidak ditemukan.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
