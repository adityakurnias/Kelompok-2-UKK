<x-app-layout>
    <div class="py-12" style="background-color: #F9F7F2; min-height: 100vh;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[40px] p-10">

                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-[#78350f]" style="font-family: 'Playfair Display', serif;">Edit Koleksi</h2>
                    <a href="{{ route('admin.products.index') }}" class="text-[#a16207] font-bold">← Batal</a>
                </div>

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-[#a16207] mb-2">NAMA PRODUK</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border-2 border-[#eaddcf] rounded-2xl p-3 outline-none" required>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-[#a16207] mb-2">HARGA (RP)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border-2 border-[#eaddcf] rounded-2xl p-3 outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#a16207] mb-2">STOK</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border-2 border-[#eaddcf] rounded-2xl p-3 outline-none" required>
                        </div>
                    </div>

                    {{-- Bagian Kategori (Solusi Gambar 8-11) --}}
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-[#a16207] mb-4">KATEGORI RUANGAN</label>
                        <div class="flex flex-wrap gap-3 p-4 bg-[#FDFCFB] rounded-3xl border-2 border-[#eaddcf] min-h-[60px]">
                            @forelse($categories as $category)
                                <label class="cursor-pointer">
                                    {{-- Value harus ID agar tidak error SQL seperti Gambar 4 & 7 --}}
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="hidden peer"
                                        {{ $product->categories->contains($category->id) ? 'checked' : '' }}>

                                    <div class="px-5 py-2 border-2 border-[#eaddcf] rounded-full text-sm font-semibold text-[#433422] peer-checked:bg-[#78350f] peer-checked:text-white peer-checked:border-[#78350f] bg-white transition-all">
                                        {{ $category->name }}
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-400 text-sm italic">Belum ada data kategori. Silakan jalankan tinker di atas.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-[#a16207] mb-2">FOTO PRODUK</label>
                        <div class="flex items-center gap-6 p-4 border-2 border-dashed border-[#eaddcf] rounded-3xl bg-gray-50">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-24 h-24 object-cover rounded-2xl shadow-md border-2 border-white">
                            @endif
                            <input type="file" name="image" class="text-sm">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#78350f] text-white font-bold py-4 rounded-2xl hover:bg-[#451a03] transition-all shadow-lg">
                        SIMPAN PERUBAHAN
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
