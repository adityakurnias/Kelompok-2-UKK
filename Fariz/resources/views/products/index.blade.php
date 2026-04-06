<x-app-layout>
    <div class="py-12 bg-[#0f172a] min-h-screen text-slate-200"> 
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
                <div class="space-y-1">
                    <h1 class="text-4xl font-black text-white tracking-tight uppercase">
                        Network <span class="text-indigo-500">Catalog</span>
                    </h1>
                    <p class="text-slate-400 font-medium">Temukan perangkat jaringan impianmu di sini.</p>
                </div>
                
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/20 uppercase tracking-widest">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Device
                    </a>
                @endif
            </div>

            <div class="flex gap-3 mb-10 overflow-x-auto pb-4 no-scrollbar">
                <a href="{{ route('products.index') }}" 
                   class="whitespace-nowrap px-6 py-2 rounded-full text-xs font-bold transition-all {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:bg-slate-700' }}">
                    ALL DEVICES
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" 
                       class="whitespace-nowrap px-6 py-2 rounded-full text-xs font-bold transition-all {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:bg-slate-700' }}">
                        {{ strtoupper($cat->name) }}
                    </a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl p-4 flex flex-col hover:border-indigo-500/50 transition-all duration-300">
                        
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-slate-900 mb-4">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                            
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="absolute top-2 right-2 flex gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}" class="p-2 bg-white/10 backdrop-blur-md text-white rounded-lg hover:bg-amber-500 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 bg-white/10 backdrop-blur-md text-white rounded-lg hover:bg-red-500 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="flex-grow space-y-1">
                            <p class="text-indigo-400 text-[10px] font-bold tracking-widest uppercase">{{ $product->category->name ?? 'Device' }}</p>
                            <h3 class="text-white font-bold text-base line-clamp-1 capitalize">{{ $product->name }}</h3>
                            <p class="text-slate-400 text-xs font-medium">Stok: {{ $product->stock }}</p>
                            <p class="text-indigo-300 font-black text-lg pt-2">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full bg-slate-700 hover:bg-indigo-600 text-white py-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2">
                                🛒 ADD TO CART
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>