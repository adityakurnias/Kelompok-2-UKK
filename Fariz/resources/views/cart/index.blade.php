<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-white leading-tight uppercase tracking-tighter">
            🛒 {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen" style="background-color: #0f172a;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl border text-sm font-bold" style="background:rgba(34,197,94,0.1); border-color:rgba(34,197,94,0.2); color:#4ade80;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-3xl overflow-hidden" style="background:#1e293b; border: 1px solid rgba(255,255,255,0.05);">
                @if(session('cart') && count(session('cart')) > 0)
                    <div class="flex flex-col md:flex-row gap-0">
                        
                        <div class="w-full md:w-2/3 p-8">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.07);">
                                            <th class="pb-4 font-black text-slate-500 uppercase text-[10px] tracking-widest">Produk</th>
                                            <th class="pb-4 font-black text-slate-500 uppercase text-[10px] tracking-widest">Harga</th>
                                            <th class="pb-4 font-black text-slate-500 uppercase text-[10px] tracking-widest text-center">Jumlah</th>
                                            <th class="pb-4 font-black text-slate-500 uppercase text-[10px] tracking-widest text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody style="divide-color: rgba(255,255,255,0.07);">
                                        @php $total = 0; @endphp
                                        @foreach(session('cart') as $id => $details)
                                            @php $total += $details['price'] * $details['quantity']; @endphp
                                            <tr class="group transition" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                                <td class="py-6 flex items-center">
                                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-16 h-16 object-cover rounded-2xl mr-4" style="background:#0f172a;">
                                                    <div>
                                                        <span class="block font-black text-white text-sm">{{ $details['name'] }}</span>
                                                        <form action="{{ route('cart.remove') }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-300 transition mt-1 flex items-center gap-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="py-6 text-slate-400 font-bold text-sm">
                                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                                </td>
                                                <td class="py-6 text-center">
                                                    <span class="text-white font-black px-3 py-1 rounded-lg text-sm" style="background:rgba(255,255,255,0.05);">{{ $details['quantity'] }}</span>
                                                </td>
                                                <td class="py-6 text-right font-black text-white text-sm">
                                                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="w-full md:w-1/3 p-8" style="background:#0f172a; border-left: 1px solid rgba(255,255,255,0.07);">
                            <h3 class="text-white text-lg font-black uppercase tracking-tighter mb-6 pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.07);">Ringkasan Pesanan</h3>
                            
                            <div class="flex justify-between mb-4 text-slate-400">
                                <span class="text-sm font-bold">Subtotal Produk</span>
                                <span class="font-black text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between mb-8 pt-4" style="border-top: 1px solid rgba(255,255,255,0.07);">
                                <span class="text-white font-black">Total Tagihan</span>
                                <span class="text-2xl font-black" style="color:#0ea5e9;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <div>
                                    <label for="name" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Pembeli</label>
                                    <input type="text" name="name" id="name" required 
                                        class="w-full rounded-xl text-white placeholder-slate-600 text-sm p-4 transition focus:outline-none focus:ring-2" 
                                        style="background:#1e293b; border: 1px solid rgba(255,255,255,0.07); focus-ring-color:#0ea5e9;"
                                        placeholder="Nama lengkap Anda">
                                </div>

                                <div>
                                    <label for="email" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Email</label>
                                    <input type="email" name="email" id="email" required 
                                        class="w-full rounded-xl text-white placeholder-slate-600 text-sm p-4 transition focus:outline-none focus:ring-2"
                                        style="background:#1e293b; border: 1px solid rgba(255,255,255,0.07);"
                                        placeholder="email@contoh.com">
                                </div>

                                <div>
                                    <label for="address" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Alamat Pengiriman</label>
                                    <textarea name="address" id="address" rows="3" required 
                                        class="w-full rounded-xl text-white placeholder-slate-600 text-sm p-4 transition focus:outline-none focus:ring-2"
                                        style="background:#1e293b; border: 1px solid rgba(255,255,255,0.07);"
                                        placeholder="Alamat lengkap pengiriman..."></textarea>
                                </div>

                                <button type="submit" class="w-full text-white font-black py-4 rounded-2xl transition duration-300 flex items-center justify-center gap-3 hover:opacity-80" style="background:#0ea5e9; box-shadow: 0 10px 30px rgba(14,165,233,0.2);">
                                    <span>Checkout Sekarang</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                @else
                    <div class="text-center py-24 px-8">
                        <div class="text-7xl mb-6">🛒</div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Keranjang Masih Kosong</h3>
                        <p class="text-slate-500 mt-3 mb-8 font-bold uppercase text-xs tracking-widest">Belum ada perangkat yang dipilih.</p>
                        <a href="{{ route('shop.index') }}" class="inline-block text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs transition hover:opacity-80" style="background:#0ea5e9;">Mulai Belanja</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>