@extends('admin.layout')

@section('page_title', 'Perbarui Informasi ATK')

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center space-x-4 mb-10">
        <a href="{{ route('admin.products.index') }}" class="p-3 bg-white hover:bg-gray-100 rounded-2xl transition-all border border-gray-100 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Edit Produk</h3>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[3rem] p-12 border border-gray-100 shadow-sm space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="md:col-span-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Nama Produk</label>
                <input type="text" name="name" required value="{{ old('name', $product->name) }}"
                    class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all tracking-tight text-lg">
                @error('name') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Kategori</label>
                <div class="relative">
                    <select name="category_id" required
                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
                @error('category_id') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Harga (Rp)</label>
                <input type="number" name="price" required value="{{ old('price', $product->price) }}"
                    class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all tracking-tight text-lg tabular-nums">
                @error('price') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Jumlah Stok</label>
                <input type="number" name="stock" required value="{{ old('stock', $product->stock) }}"
                    class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all tabular-nums">
                @error('stock') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Unggah Gambar</label>
                <div class="flex items-center space-x-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                    @endif
                    <input type="file" name="image"
                        class="flex-1 text-xs font-bold text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition-all cursor-pointer">
                </div>
                @error('image') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Detail Produk</label>
                <textarea name="description" rows="5" required
                    class="w-full bg-gray-50 border-gray-100 rounded-3xl py-4 px-6 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all resize-none shadow-inner">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-6 border-t border-gray-50 flex justify-end space-x-4">
            <a href="{{ route('admin.products.index') }}" class="py-5 px-10 rounded-2xl text-[10px] font-black text-gray-400 hover:text-gray-900 transition-all uppercase tracking-widest">Batalkan</a>
            <button type="submit" class="bg-blue-600 py-5 px-12 rounded-2xl text-white font-bold tracking-tight shadow-2xl shadow-blue-600/20 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 uppercase text-[10px] tracking-widest">
                Update Produk
            </button>
        </div>
    </form>
</div>
@endsection
