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
        .btn-premium:hover {
            background-color: #38bdf8;
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.3);
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="h-2 w-2 bg-sky-500 rounded-full animate-pulse"></div>
            <h2 class="font-bold text-xl text-white leading-tight">
                {{ __('Dashboard Jaringan Saya') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 dashboard-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="premium-card p-8 mb-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="h-20 w-20 bg-slate-900 rounded-full flex items-center justify-center text-4xl shadow-lg border-2 border-sky-500/30 text-white">
                        🌐
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-black text-white uppercase tracking-tighter">
                            HEI, <span class="accent-sky">{{ Auth::user()->name }}</span>!
                        </h1>
                        <p class="text-slate-400 font-bold uppercase text-xs tracking-widest mt-1">
                            Bersiap menemukan perangkat jaringan terbaik?
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="premium-card p-8 group">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="text-3xl">🛒</span>
                        <h4 class="font-black text-white uppercase tracking-tight">Aktivitas Belanja</h4>
                    </div>
                    <p class="text-slate-400 text-sm font-medium mb-8">Cek koleksi perangkat jaringan terbaru disini.</p>
                    <a href="{{ url('/shop') }}" class="inline-block w-full text-center btn-premium py-4 uppercase tracking-widest text-xs">
                        Mulai Belanja Sekarang
                    </a>
                </div>

                <div class="premium-card p-8 group">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="text-3xl">👤</span>
                        <h4 class="font-black text-white uppercase tracking-tight">Status Customer</h4>
                    </div>
                    <div class="space-y-3 mb-8">
                        <p class="text-sm font-bold text-slate-400">Email: <span class="text-white">{{ Auth::user()->email }}</span></p>
                        <p class="text-sm font-bold text-slate-400">Role: <span class="bg-sky-500/10 text-sky-400 px-3 py-1 rounded-full text-[10px] border border-sky-500/20 uppercase tracking-widest">CUSTOMER</span></p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="inline-block w-full text-center border-2 border-slate-700 text-slate-300 font-black py-4 rounded-2xl hover:bg-slate-700 hover:text-white transition-all uppercase tracking-widest text-xs">
                        Edit Profile
                    </a>
                </div>
            </div>

            <div class="mt-8 bg-gradient-to-r from-sky-600 to-indigo-700 rounded-[2.5rem] p-10 text-white flex flex-col md:flex-row items-center justify-between shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-black uppercase tracking-tighter mb-2">Dapatkan Diskon Member 10%</h3>
                    <p class="text-white/80 text-sm font-bold uppercase tracking-widest">Gunakan kode: <span class="bg-white/20 px-3 py-1 rounded-lg backdrop-blur-md border border-white/30">FERZNET</span></p>
                </div>
                <div class="mt-6 md:mt-0 relative z-10">
                    <a href="{{ url('/shop') }}" class="bg-white text-sky-600 px-8 py-3 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-sky-50 transition-colors shadow-xl">Klaim Sekarang</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>