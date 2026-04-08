@extends('admin.layout')

@section('page_title', 'Manajemen Transaksi')

@section('content')
<div class="flex justify-between items-center mb-10">
    <div class="flex items-center space-x-4">
        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Daftar Pesanan</h3>
        <span class="bg-gray-900 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl shadow-gray-900/10 tabular-nums">{{ $transactions->total() }} Data</span>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Filter -->
        <div class="flex items-center bg-white rounded-2xl border border-gray-100 p-2 shadow-sm">
            <a href="{{ route('admin.transactions.index') }}" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request('status') ? 'bg-gray-900 text-white shadow-lg shadow-gray-900/20' : 'text-gray-400 hover:text-gray-900' }}">Semua</a>
            <a href="{{ route('admin.transactions.index', ['status' => 'Menunggu Pembayaran']) }}" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'Menunggu Pembayaran' ? 'bg-gray-900 text-white shadow-lg shadow-gray-900/20' : 'text-gray-400 hover:text-gray-900' }}">Awaiting</a>
            <a href="{{ route('admin.transactions.index', ['status' => 'Selesai']) }}" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'Selesai' ? 'bg-gray-900 text-white shadow-lg shadow-gray-900/20' : 'text-gray-400 hover:text-gray-900' }}">Selesai</a>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.transactions.report') }}" target="_blank" class="px-5 py-3 h-full bg-blue-600 text-white rounded-xl text-[10px] uppercase tracking-widest font-bold shadow-lg shadow-blue-600/30 hover:-translate-y-0.5 hover:bg-blue-700 transition-all flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Laporan
            </a>
            <a href="{{ route('admin.transactions.report', ['pdf' => 1]) }}" class="px-5 py-3 h-full bg-red-600 text-white rounded-xl text-[10px] uppercase tracking-widest font-bold shadow-lg shadow-red-600/30 hover:-translate-y-0.5 hover:bg-red-700 transition-all flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Unduh PDF
            </a>
        </div>
    </div>
</div>

<div class="space-y-6">
    @forelse($transactions as $transaction)
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden transition-all hover:shadow-xl hover:shadow-gray-200/50">
            <div class="p-8 md:p-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-6 md:space-y-0">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-black text-sm tabular-nums shadow-inner">
                            #{{ $transaction->id }}
                        </div>
                        <div class="ml-6">
                            <h4 class="text-lg font-black text-gray-900 leading-none mb-1">{{ $transaction->shipping_name }}</h4>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest flex items-center">
                                <svg class="w-3 h-3 mr-1.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                {{ $transaction->shipping_email }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-12">
                        <div class="text-right">
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-300 block mb-1">Total Tagihan</span>
                            <span class="text-xl font-black text-gray-900 tracking-tighter tabular-nums">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex flex-col items-end">
                            <form action="{{ route('admin.transactions.update-status', $transaction->id) }}" method="POST">
                                @csrf
                                @if(in_array($transaction->status, ['Refund Diterima', 'Refund Selesai', 'Refund Ditolak']))
                                    <div class="bg-gray-100 border-none rounded-xl py-2 px-4 text-[10px] font-black uppercase tracking-widest shadow-sm {{ $transaction->status == 'Refund Ditolak' ? 'text-red-600' : 'text-blue-600' }}">
                                        {{ $transaction->status }}
                                    </div>
                                @else
                                    <select name="status" onchange="this.form.submit()"
                                        class="bg-gray-100 border-none rounded-xl py-2 px-4 text-[10px] font-black uppercase tracking-widest focus:ring-4 focus:ring-blue-600/10 cursor-pointer shadow-sm
                                        @if($transaction->status == 'Selesai') text-green-600
                                        @elseif($transaction->status == 'Menunggu Pembayaran') text-orange-600
                                        @else text-blue-600 @endif">
                                        <option value="Menunggu Pembayaran" {{ $transaction->status == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                        <option value="Menunggu Konfirmasi" {{ $transaction->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                        <option value="Diproses" {{ $transaction->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Dikirim" {{ $transaction->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="Selesai" {{ $transaction->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Diterima Pelanggan" {{ $transaction->status == 'Diterima Pelanggan' ? 'selected' : '' }}>Diterima Pelanggan</option>
                                    </select>
                                @endif
                            </form>
                            <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest mt-2">Dibuat {{ $transaction->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                @if($transaction->status == 'Diterima Pelanggan')
                <div class="mt-6 mb-2 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center space-x-3">
                    <div class="bg-green-500 p-2 rounded-xl">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-green-700 uppercase tracking-widest">Pesanan Selesai</p>
                        <p class="text-[11px] font-bold text-green-600 mt-0.5">Produk telah sampai di tujuan dan diterima oleh pelanggan.</p>
                    </div>
                </div>
                @endif

                <!-- Items Preview -->
                <div class="mt-8 pt-8 border-t border-gray-50 min-w-0">
                    <div class="flex flex-wrap gap-4">
                        @foreach($transaction->items as $item)
                            <div class="flex items-center bg-gray-50/50 p-3 rounded-2xl border border-gray-100/50 group hover:border-blue-100 transition-colors">
                                <div class="w-10 h-10 bg-white rounded-xl flex-shrink-0 border border-gray-100 flex items-center justify-center text-[10px] text-gray-300 overflow-hidden shadow-sm">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        ID{{ $item->product_id }}
                                    @endif
                                </div>
                                <div class="ml-3 pr-2">
                                    <p class="text-[11px] font-bold text-gray-700 line-clamp-1 leading-none mb-1">{{ $item->product->name ?? 'Produk Terhapus' }}</p>
                                    <p class="text-[10px] font-black text-blue-500 tabular-nums">{{ $item->quantity }}x <span class="text-gray-400 font-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</span></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-6">
                    <div class="flex-1 flex items-start space-x-4 p-6 bg-blue-50/30 rounded-3xl border border-blue-50/50">
                         <div class="bg-blue-100/50 p-3 rounded-2xl text-blue-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                         </div>
                         <div>
                             <span class="text-[9px] font-black uppercase tracking-[0.2em] text-blue-600 block mb-1">Tujuan Pengiriman</span>
                             <p class="text-xs font-bold text-gray-700 leading-relaxed">{{ $transaction->shipping_address }} <br> <span class="text-blue-500 tabular-nums">{{ $transaction->shipping_phone }}</span></p>
                         </div>
                    </div>

                    <div class="flex-1 flex items-start space-x-4 p-6 bg-indigo-50/30 rounded-3xl border border-indigo-50/50">
                         <div class="bg-indigo-100/50 p-3 rounded-2xl text-indigo-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                         </div>
                         <div>
                             <span class="text-[9px] font-black uppercase tracking-[0.2em] text-indigo-600 block mb-1">Metode Pembayaran</span>
                             <p class="text-xs font-bold text-gray-700 leading-none mb-2">{{ $transaction->payment_method ?? 'Belum dipilih' }}</p>
                             @if($transaction->payment_method == 'COD')
                                <span class="text-[9px] text-green-500 font-bold uppercase tracking-widest">Bayar di Tempat</span>
                             @elseif($transaction->payment_proof)
                                <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" class="inline-flex items-center text-[9px] bg-indigo-600 text-white font-bold uppercase tracking-widest px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                    Lihat Bukti
                                </a>
                             @else
                                <span class="text-[9px] text-orange-500 font-bold uppercase tracking-widest">Belum ada bukti</span>
                             @endif
                         </div>
                    </div>
                </div>

                @if($transaction->refund_status)
                    <div class="mt-8 p-6 rounded-3xl border flex flex-col md:flex-row justify-between items-start md:items-center gap-4
                        @if($transaction->refund_status == 'pending') bg-orange-50/50 border-orange-100
                        @elseif($transaction->refund_status == 'accepted') bg-green-50/50 border-green-100
                        @else bg-red-50/50 border-red-100 @endif
                    ">
                        <div class="flex items-start space-x-4">
                            <div class="p-2.5 rounded-xl mt-1
                                @if($transaction->refund_status == 'pending') bg-orange-500
                                @elseif($transaction->refund_status == 'accepted') bg-green-500
                                @else bg-red-500 @endif
                            ">
                                @if($transaction->refund_status == 'pending')
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @elseif($transaction->refund_status == 'accepted')
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                                @endif
                            </div>
                            <div>
                                <h5 class="text-xs font-black uppercase tracking-widest leading-none mb-1 
                                    @if($transaction->refund_status == 'pending') text-orange-600 
                                    @elseif($transaction->refund_status == 'accepted') text-green-600 
                                    @else text-red-600 @endif
                                ">
                                    Pengajuan Refund ({{ ucfirst($transaction->refund_status) }})
                                </h5>
                                <p class="text-xs font-semibold text-gray-700">Alasan: {{ $transaction->refund_reason }}</p>
                            </div>
                        </div>

                        @if($transaction->refund_status == 'pending')
                            <div class="flex flex-row gap-2 mt-4 md:mt-0">
                                <form action="{{ route('admin.transactions.refund-respond', $transaction->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="refund_action" value="accept">
                                    <button type="submit" class="px-4 py-2.5 bg-green-500 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest shadow-md hover:bg-green-600 transition-colors" onclick="return confirm('Terima refund dan kembalikan stok?')">Setuju Refund</button>
                                </form>
                                <form action="{{ route('admin.transactions.refund-respond', $transaction->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="refund_action" value="reject">
                                    <button type="submit" class="px-4 py-2.5 bg-red-500 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest shadow-md hover:bg-red-600 transition-colors" onclick="return confirm('Tolak pengajuan refund ini?')">Tolak</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="py-24 text-center bg-white rounded-[4rem] border border-dashed border-gray-200">
            <h3 class="text-xl font-black text-gray-200 uppercase tracking-[0.2em]">Belum ada data transaksi</h3>
        </div>
    @endforelse

    <div class="mt-12">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
