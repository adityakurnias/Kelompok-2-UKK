<nav x-data="{ open: false }" class="bg-white border-b-4 border-black shadow-[0_4px_0_0_rgba(0,0,0,1)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-black italic tracking-tighter text-xl border-2 border-black px-2 uppercase">
                        FEROZ NET
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
                        {{ __('Katalog Toko') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                            {{ __('Kelola Pesanan') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                            {{ __('Riwayat Pesanan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <a href="{{ route('cart.index') }}" class="relative p-2 text-black hover:bg-gray-100 transition border-2 border-transparent hover:border-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-[10px] font-black leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-black border border-white rounded-none">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border-2 border-black text-sm leading-4 font-black uppercase tracking-widest text-gray-900 bg-white hover:bg-gray-100 focus:outline-none transition ease-in-out duration-150 shadow-[2px_2px_0_0_rgba(0,0,0,1)]">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
                                <span class="text-red-600 font-bold">{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 border-2 border-black text-black hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t-4 border-black bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
                {{ __('Katalog Toko') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                    {{ __('Kelola Pesanan') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                    {{ __('Riwayat Pesanan') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                {{ __('Keranjang Belanja') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t-2 border-black bg-gray-50">
            <div class="px-4 text-center py-2">
                <div class="font-black text-base text-gray-900 uppercase italic">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <span class="text-red-600 font-bold">{{ __('Log Out') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>