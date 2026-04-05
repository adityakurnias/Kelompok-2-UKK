<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-amber-900 leading-tight">
            {{ __('Dashboard Pengelola FurniSpace') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F9F7F2] min-h-screen"> <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm p-8 mb-8 border border-amber-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center justify-center h-20 w-20 rounded-2xl bg-amber-700 text-white text-3xl shadow-lg shadow-amber-200">
                            🪑
                        </div>
                        <div>
                            <h1 class="text-3xl font-serif text-amber-900">Selamat Datang, <span class="font-bold">{{ Auth::user()->name }}</span></h1>
                            <p class="text-amber-700/60 font-medium italic">"Menciptakan ruang impian, satu furnitur sekaligus."</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-green-50 text-green-700 px-6 py-2 rounded-full font-bold text-sm border border-green-100">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        Showroom Online Aktif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-amber-50 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-amber-800/50 font-bold text-sm uppercase tracking-wider">Koleksi Produk</h3>
                        <span class="text-2xl">📦</span>
                    </div>
                    <p class="text-5xl font-serif text-amber-900">{{ \App\Models\Product::count() }}</p>
                    <p class="text-amber-600 text-sm mt-2">Item tersedia di katalog</p>
                    <a href="{{ route('admin.products.index') }}" class="mt-6 inline-flex items-center text-amber-700 font-bold text-sm hover:text-amber-900 transition-colors">
                        Kelola Katalog <span class="ml-2">→</span>
                    </a>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-8 border border-amber-50">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-amber-800/50 font-bold text-sm uppercase tracking-wider">Pelanggan Setia</h3>
                        <span class="text-2xl">✨</span>
                    </div>
                    <p class="text-5xl font-serif text-amber-900">{{ \App\Models\User::count() }}</p>
                    <p class="text-amber-600 text-sm mt-2">Member terdaftar</p>
                    <div class="mt-6 h-1 w-full bg-amber-50 rounded-full overflow-hidden">
                        <div class="bg-amber-400 h-full w-2/3"></div>
                    </div>
                </div>

                <div class="bg-amber-900 rounded-3xl shadow-xl p-8 text-amber-50">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-amber-200/50 font-bold text-sm uppercase tracking-wider">Performa Toko</h3>
                        <span class="text-2xl">🏷️</span>
                    </div>
                    <p class="text-5xl font-serif">PRIMA</p>
                    <div class="mt-6 flex items-center gap-2 text-amber-200 text-sm">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                        Sinkronisasi Real-time
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-amber-100 mb-8">
                <div class="p-6 border-b border-amber-50 flex justify-between items-center bg-white">
                    <h3 class="text-amber-900 font-bold text-lg">Pesanan Terbaru</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-amber-700 hover:bg-amber-50 px-4 py-2 rounded-xl transition-all">
                        Lihat Semua Pesanan
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-amber-50/50 text-amber-800 text-xs uppercase tracking-widest">
                                <th class="p-5 font-bold">Pelanggan</th>
                                <th class="p-5 font-bold text-right">Nilai Pesanan</th>
                                <th class="p-5 font-bold text-center">Status</th>
                                <th class="p-5 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-50">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-amber-50/30 transition-colors">
                                <td class="p-5">
                                    <p class="font-bold text-amber-900">{{ $order->user->name }}</p>
                                    <p class="text-xs text-amber-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </td>
                                <td class="p-5 text-right font-semibold text-amber-900">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="p-5 text-center">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $order->status == 'PENDING' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="p-5">
                                    <div class="flex justify-center">
                                        @if($order->status !== 'SUCCESS')
                                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="SUCCESS">
                                            <button type="submit" class="bg-amber-800 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-amber-900 transition-all shadow-md shadow-amber-200">
                                                Konfirmasi
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-green-600 font-bold text-xs flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Selesai
                                        </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-16 text-center">
                                    <div class="flex flex-col items-center opacity-40">
                                        <span class="text-5xl mb-4">📭</span>
                                        <p class="font-medium text-amber-900 uppercase tracking-widest">Belum ada pesanan masuk</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <a href="{{ route('admin.products.create') }}" class="group bg-white rounded-3xl p-8 border border-amber-100 hover:border-amber-300 transition-all hover:-translate-y-1 shadow-sm">
                    <div class="text-center">
                        <div class="text-4xl mb-4 grayscale group-hover:grayscale-0 transition-all">➕</div>
                        <h3 class="text-lg font-bold text-amber-900">Tambah Produk</h3>
                        <p class="text-amber-600 text-sm mt-1">Input koleksi furnitur baru</p>
                    </div>
                </a>

                <a href="{{ url('/shop') }}" class="group bg-white rounded-3xl p-8 border border-amber-100 hover:border-amber-300 transition-all hover:-translate-y-1 shadow-sm">
                    <div class="text-center">
                        <div class="text-4xl mb-4 grayscale group-hover:grayscale-0 transition-all">🏠</div>
                        <h3 class="text-lg font-bold text-amber-900">Lihat Showroom</h3>
                        <p class="text-amber-600 text-sm mt-1">Cek tampilan toko depan</p>
                    </div>
                </a>

                <a href="{{ url('/shop') }}" class="group bg-white rounded-3xl p-8 border border-amber-100 hover:border-amber-300 transition-all hover:-translate-y-1 shadow-sm">
                    <div class="text-center">
                        <div class="text-4xl mb-4 grayscale group-hover:grayscale-0 transition-all">🪵</div>
                        <h3 class="text-lg font-bold text-amber-900">Manajemen Stok</h3>
                        <p class="text-amber-600 text-sm mt-1">Update kuantitas & harga</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
