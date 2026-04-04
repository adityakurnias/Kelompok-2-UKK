@extends('admin.layout')

@section('page_title', 'Manajemen Transaksi')

@section('content')
<div class="flex justify-between items-center mb-10">
    <div class="flex items-center space-x-4">
        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Daftar Pesanan</h3>
        <span class="bg-gray-900 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl shadow-gray-900/10 tabular-nums">{{ $transactions->total() }} Data</span>
    </div>

    <!-- Filter -->
    <div class="flex items-center bg-white rounded-2xl border border-gray-100 p-2 shadow-sm">
        <a href="{{ route('admin.transactions.index') }}" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request('status') ? 'bg-gray-900 text-white shadow-lg shadow-gray-900/20' : 'text-gray-400 hover:text-gray-900' }}">Semua</a>
        <a href="{{ route('admin.transactions.index', ['status' => 'Menunggu Pembayaran']) }}" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'Menunggu Pembayaran' ? 'bg-gray-900 text-white shadow-lg shadow-gray-900/20' : 'text-gray-400 hover:text-gray-900' }}">Awaiting</a>
        <a href="{{ route('admin.transactions.index', ['status' => 'Selesai']) }}" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'Selesai' ? 'bg-gray-900 text-white shadow-lg shadow-gray-900/20' : 'text-gray-400 hover:text-gray-900' }}">Selesai</a>
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
                                </select>
                            </form>
                            <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest mt-2">Dibuat {{ $transaction->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

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

                <div class="mt-8 flex items-start space-x-4 p-6 bg-blue-50/30 rounded-3xl border border-blue-50/50">
                     <div class="bg-blue-100/50 p-3 rounded-2xl text-blue-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                     </div>
                     <div>
                         <span class="text-[9px] font-black uppercase tracking-[0.2em] text-blue-600 block mb-1">Tujuan Pengiriman</span>
                         <p class="text-xs font-bold text-gray-700 leading-relaxed">{{ $transaction->shipping_address }} <br> <span class="text-blue-500 tabular-nums">{{ $transaction->shipping_phone }}</span></p>
                     </div>
                </div>
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
