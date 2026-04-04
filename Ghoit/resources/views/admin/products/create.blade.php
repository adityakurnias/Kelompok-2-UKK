@extends('admin.layout')

@section('page_title', 'Input Inventori')

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center space-x-4 mb-10">
        <a href="{{ route('admin.products.index') }}" class="p-3 bg-white hover:bg-gray-100 rounded-2xl transition-all border border-gray-100 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Produk Baru</h3>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[3rem] p-12 border border-gray-100 shadow-sm space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="md:col-span-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Nama Produk</label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: Pensil Case Premium"
                    class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                @error('name') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Kategori</label>
                <div class="relative">
                    <select name="category_id" required
                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
                @error('category_id') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Harga Satuan (Rp)</label>
                <input type="number" name="price" required value="{{ old('price') }}" placeholder="0"
                    class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all tabular-nums">
                @error('price') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Stok Awal</label>
                <input type="number" name="stock" required value="{{ old('stock', 0) }}"
                    class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all tabular-nums">
                @error('stock') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Visual Produk</label>
                <input type="file" name="image"
                    class="w-full text-xs font-bold text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition-all cursor-pointer">
                @error('image') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Deskripsi Produk</label>
                <textarea name="description" rows="5" required placeholder="Spesifikasi lengkap detail barang..."
                    class="w-full bg-gray-50 border-gray-100 rounded-3xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all resize-none shadow-inner">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-6 border-t border-gray-50 flex justify-end">
            <button type="submit" class="bg-gray-900 py-5 px-12 rounded-2xl text-white font-bold tracking-tight shadow-2xl shadow-gray-900/10 hover:bg-blue-600 hover:shadow-blue-600/20 hover:-translate-y-1 transition-all active:scale-95 uppercase text-[10px] tracking-widest">
                Simpan Produk
            </button>
        </div>
    </form>
</div>
@endsection
