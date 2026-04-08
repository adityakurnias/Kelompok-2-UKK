<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Panel Admin - Toko ATK</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
    </head>
    <body class="antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">
        <div class="flex min-h-screen relative">
            <!-- Mobile sidebar backdrop -->
            <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/80 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-transition.opacity style="display: none;"></div>

            <!-- Sidebar -->
            <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed lg:sticky top-0 left-0 z-50 w-64 bg-gray-900 text-white flex-shrink-0 h-screen shadow-2xl shadow-gray-900/40 transform lg:translate-x-0 transition-transform duration-300">
                <div class="p-6">
                    <div class="flex flex-col mb-12">
                        <span class="text-2xl font-black tracking-tighter text-white leading-none">ATK<span class="text-blue-500">Admin</span></span>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500 mt-2">Konsol Manajemen</span>
                    </div>

                    <nav class="space-y-2">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-4 rounded-2xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition-all' }}">
                            <svg class="w-5 h-5 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                            <span class="text-sm font-bold">Dashboard Umum</span>
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 p-4 rounded-2xl {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition-all' }}">
                            <svg class="w-5 h-5 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            <span class="text-sm font-bold">Katalog Toko</span>
                        </a>
                        <a href="{{ route('admin.transactions.index') }}" class="flex items-center space-x-3 p-4 rounded-2xl {{ request()->routeIs('admin.transactions.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition-all' }}">
                            <svg class="w-5 h-5 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            <span class="text-sm font-bold">Daftar Transaksi</span>
                        </a>
                    </nav>
                </div>

                <div class="mt-auto p-6 border-t border-gray-800">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 text-gray-500 hover:text-white transition-colors text-[10px] font-black uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        <span>Kembali ke Toko</span>
                    </a>
                </div>
            </aside>

            <!-- Content -->
            <main class="flex-1 w-full p-4 sm:p-6 md:p-8 lg:p-10 overflow-y-auto">
                <header class="flex justify-between items-center mb-12">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="lg:hidden mr-4 p-2 -ml-2 text-gray-400 hover:text-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>
                        <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">@yield('page_title', 'Ringkasan')</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xs font-bold text-gray-600">{{ auth()->user()->name }}</span>
                        <div class="w-12 h-12 bg-blue-600 rounded-[1.2rem] flex items-center justify-center text-white font-black text-sm shadow-xl shadow-blue-600/20">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </header>

                @if(session('success'))
                    <div class="mb-10 p-5 bg-green-50 border border-green-100 text-green-700 rounded-2xl text-sm font-bold flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session('login_success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif
    </body>
</html>
