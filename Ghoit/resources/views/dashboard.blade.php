<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tighter uppercase">
            {{ __('Pesanan Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($transactions->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($transactions as $transaction)
                                <div class="bg-white rounded-[3rem] border border-gray-100 shadow-xl shadow-gray-100/20 overflow-hidden hover:-translate-y-2 transition-all group">
                                    <div class="p-10">
                                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex flex-col">
                                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 leading-none">Referensi Pesanan</span>
                                                    <span class="text-xl font-black text-gray-900 tracking-tighter tabular-nums">#{{ $transaction->id }}</span>
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('transaction.show', $transaction) }}" class="px-3 py-1.5 rounded-xl text-[9px] bg-gray-100 text-gray-600 font-black uppercase tracking-widest hover:bg-gray-200 transition-colors flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                    Detail Pesanan
                                                </a>
                                                <div class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest
                                                    @if($transaction->status == 'Selesai') bg-green-50 text-green-600
                                                    @elseif($transaction->status == 'Menunggu Pembayaran') bg-orange-50 text-orange-600
                                                    @else bg-blue-50 text-blue-600 @endif">
                                                    {{ $transaction->status }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-4 mb-10">
                                            @php $firstItem = $transaction->items->first(); @endphp
                                            @if($firstItem)
                                                <div class="flex items-center space-x-4">
                                                    <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-[10px] text-gray-400 font-bold overflow-hidden border border-gray-50 flex-shrink-0">
                                                        @if($firstItem->product && $firstItem->product->image)
                                                            <img src="{{ asset('storage/' . $firstItem->product->image) }}" class="w-full h-full object-cover">
                                                        @else
                                                            PRODUK
                                                        @endif
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="text-xs font-bold text-gray-700 line-clamp-1 leading-none">{{ $firstItem->product->name ?? 'Produk Diarsipkan' }}</p>
                                                        <p class="text-[10px] font-black text-blue-500 mt-1 leading-none">{{ $firstItem->quantity }}x <span class="text-gray-400 font-medium">Rp {{ number_format($firstItem->price, 0) }}</span></p>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($transaction->items->count() > 1)
                                                <div class="pl-14">
                                                    <p class="text-[10px] font-bold text-gray-400">+ {{ $transaction->items->count() - 1 }} produk lainnya</p>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="pt-8 border-t border-gray-50 flex justify-between items-end">
                                            <div class="flex flex-col">
                                                <span class="text-[9px] font-black uppercase tracking-widest text-gray-300 mb-1 leading-none">Total Bayar</span>
                                                <span class="text-xl font-black text-gray-900 tracking-tighter tabular-nums">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none">{{ $transaction->created_at->translatedFormat('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-24 text-center bg-white rounded-[4rem] border border-dashed border-gray-200">
                             <div class="inline-flex p-8 bg-blue-50 rounded-full mb-6">
                                <svg class="w-16 h-16 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-black text-gray-900 tracking-tighter">Belum ada transaksi</h2>
                            <p class="text-gray-400 mt-2 font-medium tracking-tight">Pembelian Anda akan muncul di sini setelah Anda membuat pesanan.</p>
                            <a href="{{ route('home') }}" class="mt-10 inline-block bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold shadow-xl shadow-blue-600/20 hover:bg-blue-700 transition-all active:scale-95">Mulai Belanja</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
