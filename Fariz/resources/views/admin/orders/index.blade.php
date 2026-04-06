<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-white leading-tight uppercase tracking-tighter">
            ⚙️ {{ __('Kelola Semua Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen" style="background-color: #0f172a;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl border text-sm font-bold" style="background:rgba(34,197,94,0.1); border-color:rgba(34,197,94,0.2); color:#4ade80;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-3xl overflow-hidden" style="background:#1e293b; border: 1px solid rgba(255,255,255,0.05);">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr style="background:#0f172a; border-bottom: 1px solid rgba(255,255,255,0.07);">
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">ID Pesanan</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Pelanggan</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Total Bayar</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Status</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Update Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="transition-colors" style="border-bottom: 1px solid rgba(255,255,255,0.04);" onmouseover="this.style.background='rgba(14,165,233,0.04)'" onmouseout="this.style.background='transparent'">
                                    <td class="px-6 py-4 text-sm font-black text-slate-400">#NET-{{ $order->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-black text-white">{{ $order->user->name ?? 'User Terhapus' }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $order->address }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-black" style="color:#0ea5e9;">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border
                                            {{ $order->status == 'pending' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : ($order->status == 'success' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20') }}">
                                            {{ $order->status == 'pending' ? 'Pending' : ($order->status == 'success' ? 'Sukses' : 'Dibatalkan') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" 
                                                class="text-xs font-bold rounded-xl px-3 py-2 cursor-pointer transition focus:outline-none focus:ring-2"
                                                style="background:#0f172a; border: 1px solid rgba(255,255,255,0.1); color:white; focus-ring-color:#0ea5e9;">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }} style="background:#1e293b;">Pending</option>
                                                <option value="success" {{ $order->status == 'success' ? 'selected' : '' }} style="background:#1e293b;">Success</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }} style="background:#1e293b;">Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center">
                                        <div class="text-5xl mb-4">📭</div>
                                        <p class="text-slate-500 font-black uppercase tracking-widest text-sm">Belum ada pesanan masuk.</p>
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
