<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            {{ __('Riwayat Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#1a1c23] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid gap-6">
                @forelse($orders as $order)
                <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(255,255,255,0.1)] p-6 flex flex-col md:flex-row justify-between items-center transition-transform hover:translate-x-1">
                    
                    <div class="mb-4 md:mb-0">
                        <p class="text-[10px] font-black uppercase text-gray-400">Order ID</p>
                        <h3 class="text-xl font-black">#NET-{{ $order->id }}</h3>
                        <p class="text-xs font-bold text-gray-600 uppercase">{{ $order->created_at->format('d M Y - H:i') }}</p>
                    </div>

                    <div class="text-center md:text-right border-t-2 md:border-t-0 md:border-l-2 border-black pt-4 md:pt-0 md:pl-8">
                        <p class="text-[10px] font-black uppercase text-gray-400">Total Pembayaran</p>
                        <p class="text-2xl font-black text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        
                        <div class="mt-2">
                            <span class="px-4 py-1 text-[10px] font-black uppercase border-2 border-black
                                {{ $order->status == 'pending' ? 'bg-yellow-400 text-black' : ($order->status == 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white') }}">
                                {{ $order->status == 'pending' ? ' Menunggu Konfirmasi' : ($order->status == 'success' ? ' Pesanan Diproses' : ' Dibatalkan') }}
                            </span>
                        </div>
                    </div>

                </div>
                @empty
                <div class="bg-gray-800 border-4 border-dashed border-gray-600 p-20 text-center">
                    <p class="text-gray-500 font-black uppercase tracking-widest text-xl italic">Belum ada riwayat belanja.</p>
                    <a href="{{ route('shop.index') }}" class="mt-4 inline-block bg-white text-black px-8 py-3 font-black uppercase hover:bg-yellow-400 transition-colors">
                        Mulai Belanja →
                    </a>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>