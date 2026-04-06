<x-app-layout>
    <head>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    </head>
    
    <style>
        body { 
            font-family: 'Instrument Sans', sans-serif !important;
        }
        .dashboard-bg { 
            background-color: #0f172a; 
            min-height: 100vh;
        }
        .premium-card {
            background: #1e293b;
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
        }
        .premium-card:hover { 
            transform: translateY(-8px);
            border-color: #0ea5e9;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .accent-sky { color: #0ea5e9; }
        .bg-sky { background-color: #0ea5e9; }
        .btn-premium {
            background-color: #0ea5e9;
            color: white !important;
            font-weight: 700;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }
        .btn-pill {
            background-color: #0ea5e9;
            color: white !important;
            font-weight: 800;
            border-radius: 9999px;
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="h-2 w-2 bg-red-500 rounded-full animate-pulse"></div>
            <h2 class="font-bold text-xl text-white leading-tight">
                {{ __('Admin Controller Panel') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 dashboard-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="premium-card p-6 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-full overflow-hidden border-2 border-sky-500/50 shadow-lg">
                            <img src="{{ asset('images/admin-foto.jpg') }}" alt="Admin Profile" class="h-full w-full object-cover">
                        </div>
                        <div>
                            <h1 class="text-2xl font-black text-white uppercase tracking-tight">Selamat Datang, <span class="accent-sky">{{ Auth::user()->name }}</span></h1>
                            <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Network Administrator Panel</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-slate-900/50 text-white px-5 py-2 rounded-full font-black text-xs tracking-tighter border border-white/5 shadow-lg">
                        <span class="inline-block h-2 w-2 bg-green-400 rounded-full animate-ping"></span>
                        SISTEM AKTIF
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div class="premium-card p-8 group">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-slate-400 font-black text-xs uppercase tracking-widest">Total Perangkat</h3>
                        <div class="text-3xl bg-slate-900 p-4 rounded-2xl text-sky-500 shadow-inner">📡</div>
                    </div>
                    <p class="text-6xl font-black text-white mb-2">{{ \App\Models\Product::count() }}</p>
                    <a href="{{ route('admin.products.index') }}" class="btn-pill inline-block mt-4">Katalog →</a>
                </div>

                <div class="premium-card p-8 group">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-slate-400 font-black text-xs uppercase tracking-widest">Total Pengguna</h3>
                        <div class="text-3xl bg-slate-900 p-4 rounded-2xl text-sky-500 shadow-inner">👥</div>
                    </div>
                    <p class="text-6xl font-black text-white mb-2">{{ \App\Models\User::count() }}</p>
                    <span class="inline-flex items-center gap-2 text-sky-400 text-xs font-black bg-sky-500/5 px-4 py-2 rounded-xl border border-sky-500/20 mt-4 uppercase tracking-widest">Database OK</span>
                </div>

                <div class="premium-card p-8 group">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-slate-400 font-black text-xs uppercase tracking-widest">Network Status</h3>
                        <div class="text-3xl bg-slate-900 p-4 rounded-2xl text-sky-500 shadow-inner">🔐</div>
                    </div>
                    <p class="text-6xl font-black text-white mb-2 italic">SECURE</p>
                    <div class="mt-4 text-green-500 font-black text-xs flex items-center gap-2 bg-green-500/5 px-4 py-2 rounded-xl border border-green-500/20">
                        <span class="h-2 w-2 bg-green-500 rounded-full animate-pulse"></span> ALL SYSTEMS NOMINAL
                    </div>
                </div>
            </div>

            <div class="premium-card overflow-hidden border-2 border-white/5 mb-8">
                <div class="bg-slate-900/50 p-6 flex justify-between items-center border-b border-white/5">
                    <h3 class="text-white font-black uppercase tracking-tighter text-lg">Recent Transactions</h3>
                    <a href="{{ route('admin.orders.index') }}" class="bg-sky-500 text-white px-4 py-2 font-black text-[10px] rounded-lg hover:bg-sky-400 uppercase tracking-widest transition-all">Semua Orderan</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800/50">
                            <tr>
                                <th class="p-6 font-black text-xs uppercase tracking-widest text-slate-400">Customer</th>
                                <th class="p-6 font-black text-xs uppercase tracking-widest text-slate-400 text-right">Value</th>
                                <th class="p-6 font-black text-xs uppercase tracking-widest text-slate-400 text-center">Status</th>
                                <th class="p-6 font-black text-xs uppercase tracking-widest text-slate-400 text-center">Control</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="p-6">
                                    <p class="font-black text-white group-hover:text-sky-400 transition-colors">{{ $order->user->name }}</p>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">{{ $order->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="p-6 text-right font-black text-white">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="p-6 text-center">
                                    <span class="px-4 py-1 text-[10px] font-black uppercase rounded-full border {{ $order->status == 'PENDING' ? 'bg-amber-500/10 text-amber-500 border-amber-500/20' : 'bg-green-500/10 text-green-500 border-green-500/20' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="p-6">
                                    <div class="flex justify-center gap-2">
                                        @if($order->status !== 'SUCCESS')
                                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="SUCCESS">
                                            <button type="submit" class="bg-sky-500 text-white px-6 py-2 text-[10px] font-black hover:bg-sky-400 transition-all uppercase rounded-xl shadow-lg shadow-sky-500/20">
                                                Approve
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-sky-400 font-black text-[10px] uppercase tracking-widest bg-sky-500/5 px-4 py-2 rounded-lg border border-sky-500/20">✓ Synchronized</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-20 text-center font-bold text-slate-500 uppercase tracking-widest italic text-sm">No recent network activity detected</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <a href="{{ route('products.create') }}" class="premium-card p-10 group hover:bg-slate-900/50">
                    <div class="text-center">
                        <div class="text-5xl mb-6 group-hover:scale-110 transition-transform">➕</div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tighter group-hover:text-sky-400 transition-colors">Tambah Perangkat</h3>
                        <p class="text-slate-500 text-[10px] mt-2 font-bold uppercase tracking-widest">Register New Hardware</p>
                    </div>
                </a>

                <a href="{{ url('/shop') }}" class="premium-card p-10 group hover:bg-slate-900/50">
                    <div class="text-center">
                        <div class="text-5xl mb-6 group-hover:scale-110 transition-transform">🛒</div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tighter group-hover:text-sky-400 transition-colors">Lihat Toko</h3>
                        <p class="text-slate-500 text-[10px] mt-2 font-bold uppercase tracking-widest">View Storefront</p>
                    </div>
                </a>

                <a href="{{ route('admin.products.index') }}" class="premium-card p-10 group hover:bg-slate-900/50">
                    <div class="text-center">
                        <div class="text-5xl mb-6 group-hover:scale-110 transition-transform">⚙️</div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tighter group-hover:text-sky-400 transition-colors">Kelola Stok</h3>
                        <p class="text-slate-500 text-[10px] mt-2 font-bold uppercase tracking-widest">Inventory Control</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>