<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-[#78350f] leading-tight uppercase tracking-wider" style="font-family: 'Playfair Display', serif;">
            {{ __('Riwayat Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid gap-6">
                @forelse($orders as $order)
                <div class="bg-white border border-[#eaddcf] rounded-[2rem] p-8 flex flex-col md:flex-row justify-between items-center transition-all duration-300 hover:shadow-xl hover:shadow-[#78350f]/5 group">

                    <div class="mb-6 md:mb-0 flex items-center gap-6">
                        <div class="w-16 h-16 bg-[#fef3c7] rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                            📦
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-[#a16207] tracking-[0.2em] mb-1">ID PESANAN</p>
                            <h3 class="text-xl font-bold text-[#433422]" style="font-family: 'Playfair Display', serif;">#FURNI-{{ $order->id }}</h3>
                            <p class="text-xs font-semibold text-gray-500 uppercase">{{ $order->created_at->format('d M Y • H:i') }}</p>
                        </div>
                    </div>

                    <div class="text-center md:text-right flex flex-col items-center md:items-end gap-2">
                        <p class="text-[10px] font-black uppercase text-[#a16207] tracking-[0.2em]">Total Investasi</p>
                        <p class="text-2xl font-black text-[#78350f]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

                        <div class="mt-2">
                            <span class="px-5 py-2 text-[10px] font-bold uppercase rounded-full tracking-widest shadow-sm
                                {{ $order->status == 'pending' ? 'bg-[#fef3c7] text-[#92400e]' : ($order->status == 'success' ? 'bg-[#dcfce7] text-[#166534]' : 'bg-[#fee2e2] text-[#991b1b]') }}">
                                ● {{ $order->status == 'pending' ? 'Menunggu Konfirmasi' : ($order->status == 'success' ? 'Pesanan Diproses' : 'Dibatalkan') }}
                            </span>
                        </div>
                    </div>

                </div>
                @empty
                <div class="bg-white border-2 border-dashed border-[#eaddcf] rounded-[3rem] p-24 text-center">
                    <div class="text-6xl mb-6 opacity-50">🛋️</div>
                    <p class="text-[#7d6e5d] font-bold uppercase tracking-[0.3em] text-lg mb-6">Belum ada furnitur yang dipesan.</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-[#78350f] text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest hover:bg-[#451a03] transition-all shadow-lg shadow-[#78350f]/20">
                        Cari Furniture →
                    </a>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
