<nav x-data="{ open: false }" style="background: rgba(15,23,42,0.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.07); position: sticky; top: 0; z-index: 50;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-black italic tracking-tighter text-xl uppercase" style="color: #0ea5e9; letter-spacing: -1px;">
                        FARIZ NET
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold uppercase tracking-widest transition-colors {{ request()->routeIs('dashboard') ? 'text-sky-400' : 'text-slate-400 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('shop.index') }}" class="text-sm font-bold uppercase tracking-widest transition-colors {{ request()->routeIs('shop.index') ? 'text-sky-400' : 'text-slate-400 hover:text-white' }}">
                        Katalog
                    </a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold uppercase tracking-widest transition-colors {{ request()->routeIs('admin.orders.index') ? 'text-sky-400' : 'text-slate-400 hover:text-white' }}">
                            Kelola Pesanan
                        </a>
                    @else
                        <a href="{{ route('orders.index') }}" class="text-sm font-bold uppercase tracking-widest transition-colors {{ request()->routeIs('orders.index') ? 'text-sky-400' : 'text-slate-400 hover:text-white' }}">
                            Riwayat Pesanan
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-400 hover:text-white transition border border-transparent hover:border-white/10 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[9px] font-black leading-none text-white transform translate-x-1/2 -translate-y-1/2 rounded-full" style="background: #0ea5e9;">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold text-white transition" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        @if(Auth::user()->role === 'admin')
                            <x-dropdown-link :href="route('admin.orders.index')">
                                {{ __('Dashboard Pesanan') }}
                            </x-dropdown-link>
                        @else
                            <x-dropdown-link :href="route('orders.index')">
                                {{ __('Riwayat Pesanan') }}
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <span class="text-red-400 font-bold">{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="border-top: 1px solid rgba(255,255,255,0.07); background: rgba(15,23,42,0.97);">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('dashboard') }}" class="block py-3 text-sm font-bold uppercase tracking-widest {{ request()->routeIs('dashboard') ? 'text-sky-400' : 'text-slate-400' }}">Dashboard</a>
            <a href="{{ route('shop.index') }}" class="block py-3 text-sm font-bold uppercase tracking-widest {{ request()->routeIs('shop.index') ? 'text-sky-400' : 'text-slate-400' }}">Katalog Toko</a>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.orders.index') }}" class="block py-3 text-sm font-bold uppercase tracking-widest {{ request()->routeIs('admin.orders.index') ? 'text-sky-400' : 'text-slate-400' }}">Kelola Pesanan</a>
            @else
                <a href="{{ route('orders.index') }}" class="block py-3 text-sm font-bold uppercase tracking-widest {{ request()->routeIs('orders.index') ? 'text-sky-400' : 'text-slate-400' }}">Riwayat Pesanan</a>
            @endif
            <a href="{{ route('cart.index') }}" class="block py-3 text-sm font-bold uppercase tracking-widest text-slate-400">Keranjang Belanja</a>
        </div>

        <div class="pt-4 pb-3 px-4" style="border-top: 1px solid rgba(255,255,255,0.07);">
            <div class="py-2">
                <div class="font-black text-base text-white uppercase italic">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-slate-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block py-3 text-sm font-bold text-slate-400 uppercase tracking-widest">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="block py-3 text-sm font-bold text-red-400 uppercase tracking-widest">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>