<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Admin - Kelola Semua Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="p-4 text-xs font-bold uppercase text-gray-600">ID</th>
                                    <th class="p-4 text-xs font-bold uppercase text-gray-600">Pelanggan</th>
                                    <th class="p-4 text-xs font-bold uppercase text-gray-600">Total Bayar</th>
                                    <th class="p-4 text-xs font-bold uppercase text-gray-600">Status</th>
                                    <th class="p-4 text-xs font-bold uppercase text-gray-600">Update Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="p-4 text-sm font-mono text-gray-500">#{{ $order->id }}</td>
                                        <td class="p-4">
                                            <div class="text-sm font-bold text-gray-800">{{ $order->user->name ?? 'User Terhapus' }}</div>
                                            <div class="text-xs text-gray-500 italic">{{ $order->address }}</div>
                                        </td>
                                        <td class="p-4 text-sm font-bold text-indigo-600">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="p-4">
                                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase 
                                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="p-4">
                                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="success" {{ $order->status == 'success' ? 'selected' : '' }}>Success</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-10 text-center text-gray-400">
                                            Belum ada pesanan masuk di database.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>