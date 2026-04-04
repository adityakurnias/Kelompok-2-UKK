@extends('admin.layout')

@section('page_title', 'Kelola ATK')

@section('content')
<div class="flex justify-between items-center mb-10">
    <div class="flex items-center space-x-4">
        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Katalog Produk</h3>
        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm shadow-blue-100">{{ $products->total() }} Produk</span>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-blue-600 py-4 px-8 rounded-2xl text-white font-bold tracking-tight shadow-xl shadow-blue-600/20 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95">
        Tambah Produk Baru
    </a>
</div>

<div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 divide-y divide-gray-100">
            <tr>
                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">Stationery</th>
                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">Kategori</th>
                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">Inventori</th>
                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">Harga</th>
                <th class="px-8 py-6 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Operasi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($products as $product)
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex-shrink-0 border border-gray-100 overflow-hidden relative group-hover:shadow-lg transition-all duration-500">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-200">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-5">
                                <h4 class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $product->name }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 tabular-nums">ID: #{{ $product->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-500 bg-gray-100 px-3 py-1.5 rounded-xl">{{ $product->category->name }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="text-sm font-black text-gray-900 tabular-nums">{{ $product->stock }} <span class="text-[10px] text-gray-400 uppercase">Unit</span></span>
                            <div class="w-24 h-1.5 bg-gray-100 rounded-full mt-2 overflow-hidden">
                                <div class="h-full bg-{{ $product->stock < 10 ? 'orange' : 'green' }}-500" style="width: {{ min($product->stock, 100) }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-sm font-black text-gray-900 tracking-tight tabular-nums">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="p-3 bg-gray-50 hover:bg-blue-50 text-gray-400 hover:text-blue-600 rounded-xl transition-all shadow-sm">
                                <svg class="w-4 h-4 text-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Arsipkan produk ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $products->links() }}
</div>
@endsection
