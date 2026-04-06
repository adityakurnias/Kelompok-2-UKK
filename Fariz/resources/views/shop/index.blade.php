<x-app-layout>
    <div class="py-10 min-h-screen" style="background-color: #0f172a;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-white uppercase tracking-tighter">Katalog Perangkat</h1>
                    <p class="text-slate-500 text-sm font-bold uppercase tracking-widest mt-1">Temukan perangkat jaringan terbaik</p>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="font-black text-xs uppercase tracking-widest px-6 py-3 rounded-xl text-white transition-all hover:scale-105" style="background:#0ea5e9; box-shadow: 0 0 20px rgba(14,165,233,0.25);">
                        + Tambah Perangkat
                    </a>
                @endif
            </div>

            <div class="flex gap-3 mb-10 overflow-x-auto pb-4 no-scrollbar">
                <a href="{{ route('products.index') }}" 
                   class="whitespace-nowrap px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all hover:scale-105 {{ !request('category') ? 'text-white' : 'text-slate-400 hover:text-white' }}"
                   style="{{ !request('category') ? 'background:#0ea5e9;' : 'background:rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);' }}">
                    Semua Perangkat
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" 
                       class="whitespace-nowrap px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all hover:scale-105 {{ request('category') == $cat->slug ? 'text-white' : 'text-slate-400 hover:text-white' }}"
                       style="{{ request('category') == $cat->slug ? 'background:#0ea5e9;' : 'background:rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach($products as $product)
                    <div class="rounded-3xl p-3 border flex flex-col min-h-[22rem] transition-all duration-300 group" style="background:#1e293b; border-color: rgba(255,255,255,0.05);" onmouseover="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 20px 40px rgba(14,165,233,0.15)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'; this.style.boxShadow='none';">

                        <div class="relative aspect-square rounded-2xl mb-3 overflow-hidden flex items-center justify-center p-2" style="background:#0f172a;">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-24 h-24 object-contain mx-auto group-hover:scale-110 transition-transform duration-300">
                            
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="absolute inset-0 bg-black/70 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('products.edit', $product->id) }}" class="bg-amber-500 p-2 rounded-lg text-white hover:bg-amber-400 shadow-lg text-xs font-bold">
                                        📝 Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus perangkat ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-600 p-2 rounded-lg text-white hover:bg-red-500 shadow-lg text-xs font-bold">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="px-2 flex-grow flex flex-col">
                            <p class="text-sky-400 text-[10px] font-black uppercase tracking-widest mb-1">
                                {{ $product->category->name ?? 'Perangkat' }}
                            </p>
                            <h3 class="text-white font-semibold text-sm line-clamp-2 mb-2 leading-tight">
                                {{ $product->name }}
                            </h3>
                            <p class="text-sky-400 font-black text-base">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full text-white font-black py-2 rounded-xl transition-all duration-300 text-sm flex items-center justify-center gap-2 hover:opacity-80" style="background:#0ea5e9;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Keranjang
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            @if($products->isEmpty())
                <div class="text-center py-24">
                    <div class="text-6xl mb-6">📡</div>
                    <p class="text-slate-500 text-lg font-bold uppercase tracking-widest">Perangkat di kategori ini belum tersedia.</p>
                    <a href="{{ route('shop.index') }}" class="mt-6 inline-block text-sky-400 font-black uppercase tracking-widest text-sm hover:text-white transition-colors">← Lihat Semua</a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>
