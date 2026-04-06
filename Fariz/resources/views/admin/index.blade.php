<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase tracking-tighter italic">
            {{ __('Panel Admin - Kelola Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#1a1c23] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white border-4 border-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] overflow-hidden p-6">
                
                <div class="flex justify-between items-center mb-6 border-b-4 border-black pb-4">
                    <h3 class="text-2xl font-black uppercase tracking-tighter">PANEL PESANAN</h3>
                    <div class="bg-black text-white px-3 py-1 text-xs font-bold uppercase tracking-widest">
                        Total: {{ $orders->count() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-black text-white uppercase text-xs tracking-widest">
                                <th class="p-4 font-black">ID</th>
                                <th class="p-4 font-black">Pembeli</th>
                                <th class="p-4 font-black">Total Harga</th>
                                <th class="p-4 font-black text-center">Status</th>
                                <th class="p-4 font-black text-center border-l-2 border-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-black">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="p-4 font-black">#{{ $order->id }}</td>
                                <td class="p-4">
                                    <div class="font-black text-gray-900 uppercase italic">{{ $order->user->name }}</div>
                                    <div class="text-[10px] text-gray-500 font-bold uppercase">{{ $order->address }}</div>
                                </td>
                                <td class="p-4 font-black text-lg">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 border-2 border-black text-[10px] font-black uppercase 
                                        {{ $order->status == 'pending' ? 'bg-yellow-400 text-black' : ($order->status == 'success' ? 'bg-green-400 text-black' : 'bg-red-500 text-white') }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="p-4 border-l-2 border-gray-200">
                                    <div class="flex justify-center gap-3">
                                        @if($order->status == 'pending')
                                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="success">
                                                <button type="submit" class="bg-black text-white px-4 py-2 text-[10px] font-black uppercase hover:bg-green-500 hover:text-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.3)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                                                    APPROVE 
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="border-2 border-black text-black px-4 py-2 text-[10px] font-black uppercase hover:bg-red-500 transition-all">
                                                    REJECT 
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-[10px] font-black uppercase italic tracking-widest">Process Completed</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center font-black text-gray-400 uppercase tracking-widest italic bg-gray-50">
                                    Gudang Kosong - Belum ada pesanan masuk.
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