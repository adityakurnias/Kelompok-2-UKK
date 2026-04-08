<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tighter uppercase">
            {{ __('Detail Pesanan') }} #{{ $transaction->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex gap-4">
                <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-50 active:bg-gray-100 transition ease-in-out duration-150">
                    &larr; Kembali
                </a>
                <a href="{{ route('transaction.invoice', $transaction) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-50 border border-blue-100 rounded-xl font-bold text-sm text-blue-700 uppercase tracking-widest hover:bg-blue-100 transition ease-in-out duration-150">
                    Cetak Invoice
                </a>
            </div>

            <div class="bg-white rounded-[3rem] border border-gray-100 shadow-xl shadow-gray-100/20 overflow-hidden">
                <div class="p-10 border-b border-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex-1">
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Status Pesanan</p>
                        <div class="inline-block px-4 py-2 rounded-xl text-sm font-black uppercase tracking-widest
                            @if(in_array($transaction->status, ['Selesai', 'Refund Selesai', 'Diterima Pelanggan'])) bg-green-50 text-green-600
                            @elseif($transaction->status == 'Menunggu Pembayaran') bg-orange-50 text-orange-600
                            @elseif($transaction->status == 'Refund Diterima') bg-blue-50 text-blue-600
                            @elseif($transaction->status == 'Refund Ditolak') bg-red-50 text-red-600
                            @else bg-blue-50 text-blue-600 @endif">
                            {{ $transaction->status }}
                        </div>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Tanggal Pemesanan</p>
                        <p class="text-base font-bold text-gray-900 tracking-tight">{{ $transaction->created_at->translatedFormat('l, d F Y H:i') }}</p>
                    </div>
                </div>

                <div class="p-10">
                    <h3 class="text-base font-black text-gray-900 tracking-widest uppercase mb-6 flex items-center">
                        <span class="w-3 h-3 rounded-full bg-blue-500 mr-3"></span>
                        Daftar Produk
                    </h3>

                    <div class="space-y-6">
                        @foreach($transaction->items as $item)
                            <div class="flex items-center space-x-6 p-4 rounded-2xl bg-gray-50/50 border border-gray-50">
                                <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center text-xs text-gray-400 font-bold overflow-hidden shadow-sm flex-shrink-0">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        PRODUK
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-base font-bold text-gray-900 leading-none mb-2">{{ $item->product->name ?? 'Produk Diarsipkan' }}</p>
                                    <p class="text-sm font-medium text-gray-500">Harga Satuan: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-gray-400 mb-1">x{{ $item->quantity }}</p>
                                    <p class="text-base font-bold text-blue-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-50 border-t border-gray-50">
                    <div class="p-10">
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-gray-500 mb-4">Informasi Pembayaran</h3>
                        <p class="text-base font-bold text-gray-900 mb-1">Metode: <span class="font-medium text-gray-600">{{ $transaction->payment_method ?? 'Transfer Bank' }}</span></p>
                        @if($transaction->refund_status)
                            <div class="mt-4 p-4 rounded-xl {{ $transaction->refund_status == 'accepted' ? 'bg-green-50 border border-green-100' : ($transaction->refund_status == 'rejected' ? 'bg-red-50 border border-red-100' : 'bg-orange-50 border border-orange-100') }}">
                                <p class="text-sm font-black uppercase tracking-widest {{ $transaction->refund_status == 'accepted' ? 'text-green-600' : ($transaction->refund_status == 'rejected' ? 'text-red-600' : 'text-orange-600') }} mb-1">Status Refund</p>
                                <p class="text-base font-medium text-gray-700 capitalize">{{ $transaction->refund_status }}</p>
                                @if($transaction->refund_reason)<p class="text-sm text-gray-500 mt-2 border-t border-gray-200/50 pt-2"><span class="font-bold">Alasan:</span> {{ $transaction->refund_reason }}</p>@endif
                            </div>
                        @endif
                    </div>
                    <div class="p-10 bg-gray-50/30">
                        <div class="space-y-3 mb-6 border-b border-gray-100 pb-6">
                            <div class="flex justify-between text-base">
                                <span class="font-medium text-gray-500">Subtotal Produk</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-black uppercase tracking-[0.2em] text-gray-500 mb-1">Total Belanja</span>
                            <span class="text-3xl font-black text-gray-900 tracking-tighter tabular-nums text-right">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Action Panels Moved from Dashboard -->
            @if($transaction->status == 'Menunggu Pembayaran')
                <div class="mt-8 bg-gray-900 rounded-[2rem] p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 shadow-xl shadow-gray-900/20">
                    <div class="flex items-center space-x-5">
                        <div class="bg-blue-600 p-3.5 rounded-2xl">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-lg font-black text-white tracking-widest uppercase mb-1">Upload Bukti Pembayaran</p>
                            <p class="text-sm font-medium text-gray-300">Admin menunggu upload bukti dari metode <strong class="text-white">{{ $transaction->payment_method ?? 'Pembayaran' }}</strong>.</p>
                        </div>
                    </div>
                    <a href="{{ route('checkout.payment', $transaction) }}" class="whitespace-nowrap px-8 py-5 w-full sm:w-auto text-center bg-blue-600 text-white font-black rounded-2xl text-sm uppercase tracking-widest shadow-lg shadow-blue-600/30 hover:-translate-y-1 hover:bg-blue-500 transition-all active:scale-95">Bayar Sekarang</a>
                </div>
            @endif

            @if($transaction->status == 'Selesai' && !$transaction->refund_status)
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <form action="{{ route('transaction.complete', $transaction) }}" method="POST" class="bg-white p-8 rounded-[2rem] shadow-sm border border-green-100 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            @csrf
                            <div class="flex items-center space-x-3 mb-4 text-green-600">
                                <div class="bg-green-100 p-3 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <h4 class="text-sm font-black uppercase tracking-widest">Konfirmasi Penerimaan</h4>
                            </div>
                            <p class="text-base text-gray-600 mb-8 font-medium leading-relaxed">Pilih ini jika paket sudah sampai dengan selamat dan Anda tidak ingin mengajukan refund.</p>
                            <button type="submit" class="w-full text-center px-6 py-5 bg-green-500 text-gray-900 font-black rounded-xlg text-sm uppercase tracking-widest shadow-lg shadow-green-500/30 hover:-translate-y-1 hover:bg-green-400 transition-all active:scale-95" onclick="return confirm('Selesaikan pesanan dan hapus dari dashboard?')">
                                Selesaikan Pesanan
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('transaction.refund', $transaction) }}" method="POST" class="bg-white p-8 rounded-[2rem] shadow-sm border border-red-100 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            @csrf
                            <div class="flex items-center space-x-3 mb-4 text-red-600">
                                <div class="bg-red-100 p-3 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <h4 class="text-sm font-black uppercase tracking-widest">Ajukan Refund</h4>
                            </div>
                            <input type="text" name="refund_reason" required minlength="5" class="w-full bg-gray-50 border-gray-200 rounded-xl py-4 px-5 text-base focus:bg-white focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all mb-4" placeholder="Alasan komplain / cacat produk...">
                            <button type="submit" class="w-full text-center px-6 py-5 bg-red-50 text-red-600 font-black rounded-xlg text-sm uppercase tracking-widest border border-red-200 hover:bg-red-100 transition-all active:scale-95" onclick="return confirm('Ajukan refund ke tim admin?')">
                                Ajukan Refund
                            </button>
                        </div>
                    </form>
                </div>
            @elseif($transaction->refund_status == 'pending')
                <div class="mt-8 bg-orange-50 rounded-[2rem] p-8 flex items-center gap-5 border border-orange-100 shadow-sm">
                    <div class="bg-orange-500 p-5 rounded-2xl shadow-lg shadow-orange-500/20">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-black text-orange-600 uppercase tracking-widest mb-1">Permintaan Refund Diproses</p>
                        <p class="text-base text-gray-700 font-medium">Harap tunggu konfirmasi dari tim admin, pesanan ini sedang ditinjau.</p>
                    </div>
                </div>
            @elseif($transaction->refund_status == 'rejected')
                <div class="mt-8 bg-red-50 rounded-[2rem] p-8 flex items-center gap-5 border border-red-100 shadow-sm">
                    <div class="bg-red-500 p-5 rounded-2xl shadow-lg shadow-red-500/20">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-black text-red-600 uppercase tracking-widest mb-1">Permintaan Refund Ditolak</p>
                        <p class="text-base text-gray-700 font-medium">Pengajuan refund Anda tidak dapat disetujui. Pesanan Anda tetap berstatus selesai.</p>
                    </div>
                </div>
            @elseif($transaction->refund_status == 'accepted')
                <div class="mt-8 bg-green-50 rounded-[2rem] p-8 flex flex-col md:flex-row items-center gap-6 border border-green-200 shadow-sm justify-between">
                    <div class="flex items-center gap-5">
                        <div class="bg-green-500 p-5 rounded-2xl shadow-lg shadow-green-500/20">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div class="flex-1 space-y-1">
                            <p class="text-sm font-black text-green-700 uppercase tracking-widest">Permintaan Refund Disetujui</p>
                            <p class="text-base text-gray-700 font-medium">Dana refund Anda telah/sedang dikirim. Harap konfirmasi jika setuju.</p>
                        </div>
                    </div>
                    <form action="{{ route('transaction.refund-received', $transaction) }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        <button type="submit" class="w-full md:w-auto whitespace-nowrap px-8 py-5 bg-green-500 text-gray-900 font-black rounded-xl text-sm uppercase tracking-widest shadow-lg shadow-green-500/30 hover:-translate-y-1 hover:bg-green-400 transition-all active:scale-95" onclick="return confirm('Konfirmasi bahwa uang refund telah Anda terima?')">
                            Uang Telah Diterima
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
