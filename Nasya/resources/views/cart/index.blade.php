<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#78350f] leading-tight uppercase tracking-widest" style="font-family: 'Playfair Display', serif;">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-[#dcfce7] border-l-4 border-[#166534] text-[#166534] rounded-r-xl font-medium shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-[#78350f]/5 p-8 border border-[#eaddcf]">
                @if(session('cart') && count(session('cart')) > 0)
                    <div class="flex flex-col lg:flex-row gap-12">

                        <div class="w-full lg:w-2/3">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-separate border-spacing-y-4">
                                    <thead>
                                        <tr class="text-[#a16207] uppercase text-[10px] tracking-[0.2em] font-black">
                                            <th class="pb-2 pl-4">Produk Furniture</th>
                                            <th class="pb-2">Harga</th>
                                            <th class="pb-2 text-center">Jumlah</th>
                                            <th class="pb-2 text-right pr-4">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach(session('cart') as $id => $details)
                                            @php $total += $details['price'] * $details['quantity']; @endphp
                                            <tr class="bg-[#F9F7F2]/50 hover:bg-[#F9F7F2] transition-colors duration-300 group">
                                                <td class="py-4 pl-4 rounded-l-2xl">
                                                    <div class="flex items-center">
                                                        <img src="{{ asset('storage/' . $details['image']) }}" class="w-20 h-20 object-cover rounded-xl mr-5 border border-[#eaddcf] shadow-sm group-hover:scale-105 transition-transform">
                                                        <div>
                                                            <span class="block font-bold text-[#433422] text-lg leading-tight">{{ $details['name'] }}</span>
                                                            <form action="{{ route('cart.remove') }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="id" value="{{ $id }}">
                                                                <button type="submit" class="text-[10px] font-bold text-red-400 hover:text-red-600 uppercase tracking-wider mt-2 transition-colors">Hapus Item</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 text-[#7d6e5d] font-semibold">
                                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                                </td>
                                                <td class="py-4 text-center font-bold text-[#433422]">
                                                    <span class="bg-white px-3 py-1 rounded-lg border border-[#eaddcf]">{{ $details['quantity'] }}</span>
                                                </td>
                                                <td class="py-4 text-right pr-4 rounded-r-2xl font-black text-[#78350f]">
                                                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="w-full lg:w-1/3">
                            <div class="bg-[#F9F7F2] p-8 rounded-[2rem] border border-[#eaddcf] sticky top-24">
                                <h3 class="text-xl font-bold text-[#433422] mb-6 border-b border-[#eaddcf] pb-4" style="font-family: 'Playfair Display', serif;">Ringkasan Pesanan</h3>

                                <div class="flex justify-between mb-4">
                                    <span class="text-[#7d6e5d] font-medium">Subtotal Koleksi</span>
                                    <span class="font-bold text-[#433422]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>

                                <div class="flex justify-between mb-8 pt-4 border-t border-[#eaddcf]">
                                    <span class="text-lg font-bold text-[#433422]">Total Investasi</span>
                                    <span class="text-2xl font-black text-[#78350f]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>

                                <form action="{{ route('checkout.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-6">
                                        <label for="address" class="block text-[10px] font-black text-[#a16207] uppercase tracking-widest mb-3">Alamat Pengiriman</label>
                                        <textarea
                                            name="address"
                                            id="address"
                                            rows="4"
                                            required
                                            class="w-full rounded-2xl border-[#eaddcf] bg-white shadow-sm focus:ring-[#78350f] focus:border-[#78350f] text-sm text-[#433422] placeholder:text-gray-300"
                                            placeholder="Masukkan alamat pengiriman lengkap..."></textarea>
                                    </div>

                                    <button type="submit" class="w-full bg-[#78350f] hover:bg-[#451a03] text-white font-bold py-5 rounded-2xl transition-all duration-300 shadow-lg shadow-[#78350f]/20 flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                                        <span>Konfirmasi Pesanan</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                                <p class="text-[10px] text-center text-[#a16207] mt-6 font-medium uppercase tracking-tighter italic">Pengecekan kualitas dilakukan sebelum pengiriman.</p>
                            </div>
                        </div>

                    </div>
                @else
                    <div class="text-center py-24">
                        <div class="text-6xl mb-6 opacity-30">🛒</div>
                        <h3 class="text-2xl font-bold text-[#433422]" style="font-family: 'Playfair Display', serif;">Keranjang Masih Kosong</h3>
                        <p class="text-[#7d6e5d] mt-2 mb-8">Anda belum menambahkan koleksi furniture ke keranjang.</p>
                        <a href="{{ route('shop.index') }}" class="inline-block bg-[#78350f] text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-[#451a03] transition-all shadow-lg shadow-[#78350f]/20">
                            Lihat Katalog Furniture
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
