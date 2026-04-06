<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-white leading-tight uppercase tracking-tighter">
            📦 {{ __('Riwayat Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen" style="background-color: #0f172a;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid gap-4">
                @forelse($orders as $order)
                <div class="rounded-2xl p-6 flex flex-col md:flex-row justify-between items-center transition-all hover:-translate-y-1" style="background:#1e293b; border: 1px solid rgba(255,255,255,0.05);" onmouseover="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 10px 30px rgba(14,165,233,0.1)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'; this.style.boxShadow='none';">
                    
                    <div class="mb-4 md:mb-0">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Order ID</p>
                        <h3 class="text-xl font-black text-white">#NET-{{ $order->id }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $order->created_at->format('d M Y - H:i') }}</p>
                    </div>

                    <div class="text-center md:text-right pt-4 md:pt-0 md:pl-8" style="border-top: 1px solid rgba(255,255,255,0.07);" >
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Pembayaran</p>
                        <p class="text-2xl font-black" style="color:#0ea5e9;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        
                        <div class="mt-2">
                            <span class="px-4 py-1 text-[10px] font-black uppercase rounded-full border
                                {{ $order->status == 'pending' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : ($order->status == 'success' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20') }}">
                                {{ $order->status == 'pending' ? 'Menunggu Konfirmasi' : ($order->status == 'success' ? 'Pesanan Diproses' : 'Dibatalkan') }}
                            </span>
                        </div>
                    </div>

                </div>
                @empty
                <div class="text-center py-24 rounded-3xl" style="background:#1e293b; border: 1px dashed rgba(255,255,255,0.1);">
                    <div class="text-6xl mb-6">📦</div>
                    <p class="text-slate-500 font-black uppercase tracking-widest text-lg">Belum ada riwayat belanja.</p>
                    <a href="{{ route('shop.index') }}" class="mt-6 inline-block text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest text-xs hover:opacity-80 transition" style="background:#0ea5e9;">
                        Mulai Belanja →
                    </a>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>