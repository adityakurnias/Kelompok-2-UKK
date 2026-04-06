<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl p-8 border border-gray-100">
                @if(session('cart') && count(session('cart')) > 0)
                    <div class="flex flex-col md:flex-row gap-10">
                        
                        <div class="w-full md:w-2/3">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-gray-100">
                                            <th class="pb-4 font-bold text-gray-400 uppercase text-xs tracking-widest">Produk</th>
                                            <th class="pb-4 font-bold text-gray-400 uppercase text-xs tracking-widest">Harga</th>
                                            <th class="pb-4 font-bold text-gray-400 uppercase text-xs tracking-widest text-center">Jumlah</th>
                                            <th class="pb-4 font-bold text-gray-400 uppercase text-xs tracking-widest text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @php $total = 0; @endphp
                                        @foreach(session('cart') as $id => $details)
                                            @php $total += $details['price'] * $details['quantity']; @endphp
                                            <tr class="group hover:bg-gray-50/50 transition">
                                                <td class="py-6 flex items-center">
                                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-20 h-20 object-cover rounded-2xl mr-4 shadow-sm border border-gray-100">
                                                    <div>
                                                        <span class="block font-bold text-slate-800 text-lg">{{ $details['name'] }}</span>
                                                        <form action="{{ route('cart.remove') }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-700 transition mt-2 flex items-center gap-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="py-6 text-slate-500 font-medium">
                                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                                </td>
                                                <td class="py-6 text-center text-slate-700 font-bold">
                                                    <span class="bg-gray-100 px-3 py-1 rounded-lg">{{ $details['quantity'] }}</span>
                                                </td>
                                                <td class="py-6 text-right font-black text-slate-900 text-lg">
                                                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="w-full md:w-1/3">
                            <div class="bg-slate-900 p-8 rounded-3xl shadow-2xl shadow-slate-200">
                                <h3 class="text-white text-xl font-bold mb-6 border-b border-slate-800 pb-4">Ringkasan Pesanan</h3>
                                
                                <div class="flex justify-between mb-4 text-slate-400">
                                    <span class="text-sm">Subtotal Produk</span>
                                    <span class="font-semibold text-slate-200">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="flex justify-between mb-8 pt-4 border-t border-slate-800">
                                    <span class="text-white font-bold">Total Tagihan</span>
                                    <span class="text-2xl font-black text-indigo-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>

                                <form action="{{ route('checkout.store') }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Pembeli</label>
                                        <input 
                                            type="text" 
                                            name="name" 
                                            id="name" 
                                            required 
                                            class="w-full rounded-xl border-none bg-slate-800 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 text-sm p-4 transition"
                                            placeholder="Nama lengkap Anda">
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Email</label>
                                        <input 
                                            type="email" 
                                            name="email" 
                                            id="email" 
                                            required 
                                            class="w-full rounded-xl border-none bg-slate-800 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 text-sm p-4 transition"
                                            placeholder="email@contoh.com">
                                    </div>

                                    <div class="mb-6">
                                        <label for="address" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Alamat Pengiriman</label>
                                        <textarea 
                                            name="address" 
                                            id="address" 
                                            rows="3" 
                                            required 
                                            class="w-full rounded-xl border-none bg-slate-800 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 text-sm p-4 transition"
                                            placeholder="Alamat lengkap pengiriman..."></textarea>
                                    </div>

                                    <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-black py-4 rounded-2xl transition duration-300 shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-3">
                                        <span>Checkout Sekarang</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @else
                    <div class="text-center py-20">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800">Keranjang Masih Kosong</h3>
                        <p class="text-slate-500 mt-2 mb-8">Sepertinya kamu belum memilih musik favoritmu.</p>
                        <a href="{{ route('shop.index') }}" class="inline-block bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-slate-800 transition shadow-lg">Mulai Belanja</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>