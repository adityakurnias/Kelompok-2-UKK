<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl text-[#433422] leading-tight">
            {{ __('Detail Koleksi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F9F7F2] min-h-screen text-[#433422]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8">
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-[#8b7355] hover:text-[#78350f] transition-colors font-bold uppercase tracking-widest text-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Katalog
                </a>
            </div>

            <div class="bg-white rounded-[2rem] border border-[#eaddcf] shadow-sm overflow-hidden flex flex-col md:flex-row">

                <div class="md:w-1/2 bg-[#fdf8f3] p-10 flex items-center justify-center relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-2xl shadow-sm">
                    @else
                        <div class="w-full aspect-square flex items-center justify-center text-[#eaddcf]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="md:w-1/2 p-10 lg:p-14 flex flex-col">

                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($product->categories as $cat)
                            <span class="bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg text-xs font-black text-[#78350f] uppercase border border-[#eaddcf]">
                                {{ $cat->name }}
                            </span>
                        @endforeach
                    </div>

                    <h1 class="text-4xl text-[#433422] font-bold mb-4 capitalize leading-tight" style="font-family: 'Playfair Display', serif;">
                        {{ $product->name }}
                    </h1>

                    <p class="text-[#78350f] font-black text-3xl mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    @if($product->description)
                    <div class="prose prose-sm text-[#8b7355] mb-8 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                    @endif

                    <div class="space-y-6 mb-10 pb-10 border-b border-[#f9f7f2]">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-[#fdf8f3] border border-[#eaddcf] flex items-center justify-center text-[#78350f]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-[#a16207] font-bold uppercase tracking-widest">Ketersediaan Stok</p>
                                <p class="text-lg font-medium text-[#433422]">{{ $product->stock }} Item Tersedia</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-[#fdf8f3] border border-[#eaddcf] flex items-center justify-center text-[#78350f]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-[#a16207] font-bold uppercase tracking-widest">Pengiriman</p>
                                <p class="text-lg font-medium text-[#433422]">Siap dikirim ke lokasi Anda</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" @if($product->stock <= 0) disabled @endif 
                                    class="w-full py-4 rounded-xl font-bold uppercase tracking-widest text-sm transition-all
                                    @if($product->stock > 0)
                                        bg-[#78350f] text-white hover:bg-[#451a03] active:scale-95 shadow-[#78350f]/20
                                    @else cursor-not-allowed shadow-none
                                    @endif">
                                @if($product->stock > 0)
                                    <div class="flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </div>
                                @else
                                    Stok Habis
                                @endif
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
