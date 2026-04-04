@extends('admin.layout')

@section('page_title', 'Ringkasan Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-4">Total Pesanan</span>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-gray-900 tracking-tighter tabular-nums">{{ $totalTransactions }}</h3>
            <div class="p-3 bg-blue-50 rounded-2xl">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
        </div>
    </div>
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-4">Total Pendapatan</span>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-gray-900 tracking-tighter tabular-nums">Rp {{ number_format($totalSales / 1000, 0) }}rb</h3>
            <div class="p-3 bg-green-50 rounded-2xl">
                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
    </div>
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-4">Stok Menipis</span>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-gray-900 tracking-tighter tabular-nums">{{ $lowStockProducts->count() }}</h3>
            <div class="p-3 bg-orange-50 rounded-2xl">
                <svg class="w-6 h-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
        </div>
    </div>
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-4">Proses Rata-rata</span>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-gray-900 tracking-tighter">Cepat</h3>
            <div class="p-3 bg-indigo-50 rounded-2xl">
                <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
    <!-- Recent Transactions -->
    <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm">
        <h4 class="text-xl font-black text-gray-900 tracking-tight mb-8">Aktivitas Terkini</h4>
        <div class="space-y-6">
            @foreach($recentTransactions as $transaction)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-50 group-hover:bg-blue-50 rounded-2xl flex items-center justify-center transition-colors">
                            <span class="text-xs font-black text-blue-600 tabular-nums">ID{{ $transaction->id }}</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-bold text-gray-900 leading-none mb-1">{{ $transaction->shipping_name }}</p>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ $transaction->user->email }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-gray-900 tabular-nums mb-1">Rp {{ number_format($transaction->total_price, 0) }}</p>
                        <span class="text-[9px] font-black uppercase tracking-widest px-2 py-1 rounded-lg {{ $transaction->status == 'Selesai' ? 'bg-green-50 text-green-600' : 'bg-orange-50 text-orange-600' }}">
                            {{ $transaction->status }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('admin.transactions.index') }}" class="mt-10 block text-center py-4 bg-gray-50 rounded-2xl text-[10px] font-black text-gray-400 hover:text-blue-600 hover:bg-blue-50 uppercase tracking-[0.2em] transition-all">Lihat Semua Transaksi</a>
    </div>

    <!-- Low Stock Alert -->
    <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm">
        <h4 class="text-xl font-black text-gray-900 tracking-tight mb-8">Pantauan Stok</h4>
        <div class="space-y-6">
            @forelse($lowStockProducts as $product)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center overflow-hidden border border-gray-50">
                             @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded-2xl">
                             @else
                                <svg class="w-6 h-6 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                             @endif
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-bold text-gray-900 leading-none mb-1">{{ $product->name }}</p>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ $product->category->name }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-red-50 text-red-600 rounded-xl text-[10px] font-black tracking-tight tabular-nums">
                        Sisa {{ $product->stock }}
                    </span>
                </div>
            @empty
                <div class="py-12 text-center">
                    <p class="text-[10px] font-black text-gray-300 tracking-widest uppercase">Level stok dalam kondisi aman</p>
                </div>
            @endforelse
        </div>
        <a href="{{ route('admin.products.index') }}" class="mt-10 block text-center py-4 bg-gray-50 rounded-2xl text-[10px] font-black text-gray-400 hover:text-blue-600 hover:bg-blue-50 uppercase tracking-[0.2em] transition-all">Kelola Katalog</a>
    </div>
</div>
@endsection
