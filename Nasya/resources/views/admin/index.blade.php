<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl text-[#433422] leading-tight">
            {{ __('Manajemen Pesanan FurniSpace') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border border-[#eaddcf] rounded-2xl shadow-sm overflow-hidden">

                <div class="flex justify-between items-center p-6 border-b border-[#eaddcf] bg-white/50">
                    <div>
                        <h3 class="text-lg font-bold text-[#433422] flex items-center gap-2">
                            <span class="w-2 h-6 bg-[#78350f] rounded-full"></span>
                            DAFTAR PESANAN MASUK
                        </h3>
                        <p class="text-xs text-[#a16207] font-medium uppercase tracking-wider mt-1">Pantau dan proses transaksi pelanggan</p>
                    </div>
                    <div class="bg-[#fdf8f3] text-[#78350f] px-4 py-2 rounded-xl border border-[#eaddcf] text-sm font-bold">
                        Total Pesanan: {{ $orders->count() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#fdf8f3] text-[#78350f] uppercase text-[11px] tracking-[0.15em] font-bold">
                                <th class="p-5">ID Order</th>
                                <th class="p-5">Informasi Pembeli</th>
                                <th class="p-5">Total Transaksi</th>
                                <th class="p-5 text-center">Status</th>
                                <th class="p-5 text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f3ede4]">
                            @forelse($orders as $order)
                            <tr class="hover:bg-[#fcfaf7] transition-all group">
                                <td class="p-5">
                                    <span class="font-mono font-bold text-[#a16207]">#{{ $order->id }}</span>
                                </td>
                                <td class="p-5">
                                    <div class="font-bold text-[#433422]">{{ $order->user->name }}</div>
                                    <div class="text-[11px] text-[#8b7355] mt-0.5 line-clamp-1 italic">{{ $order->address }}</div>
                                </td>
                                <td class="p-5">
                                    <span class="font-bold text-[#78350f] text-base">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="p-5 text-center">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-[#fef3c7] text-[#92400e] border-[#fde68a]',
                                            'success' => 'bg-[#d1fae5] text-[#065f46] border-[#a7f3d0]',
                                            'cancelled' => 'bg-[#fee2e2] text-[#991b1b] border-[#fecaca]'
                                        ];
                                        $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600';
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-full border text-[10px] font-bold uppercase tracking-wider {{ $class }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="p-5">
                                    <div class="flex justify-center gap-2">
                                        @if($order->status == 'pending')
                                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="success">
                                                <button type="submit" class="bg-[#78350f] text-white px-4 py-2 rounded-lg text-[11px] font-bold uppercase tracking-tight hover:bg-[#433422] transition-colors shadow-sm">
                                                    Terima
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="bg-white text-[#991b1b] border border-[#fecaca] px-4 py-2 rounded-lg text-[11px] font-bold uppercase tracking-tight hover:bg-[#fee2e2] transition-colors">
                                                    Tolak
                                                </button>
                                            </form>
                                        @else
                                            <span class="flex items-center gap-1 text-[#8b7355] text-[10px] font-bold uppercase italic opacity-60">
                                                <i class="fas fa-check-circle"></i> Selesai
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-20 text-center bg-white">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-[#fdf8f3] rounded-full flex items-center justify-center mb-4 text-[#eaddcf]">
                                            <i class="fas fa-box-open text-2xl"></i>
                                        </div>
                                        <p class="font-serif text-[#8b7355] text-lg italic">Belum ada pesanan yang masuk saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
