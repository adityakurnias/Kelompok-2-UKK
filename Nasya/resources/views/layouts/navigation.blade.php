<nav x-data="{ open: false }" class="bg-[#F9F7F2] border-b-4 border-[#78350f] shadow-[0_4px_0_0_rgba(120,53,15,0.1)] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2 font-extrabold tracking-wider text-xl border-2 border-[#78350f] px-4 py-2 uppercase bg-[#78350f] text-white hover:bg-[#451a03] transition-colors duration-300 shadow-[4px_4px_0_0_rgba(67,52,34,0.2)]">
                        <span class="text-2xl">🪑</span>
                        <span style="font-family: 'Playfair Display', serif;">FURNISPACE</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#433422] font-bold hover:text-[#78350f] border-[#78350f]">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')" class="text-[#433422] font-bold hover:text-[#78350f] border-[#78350f]">
                        {{ __('Katalog Furniture') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')" class="text-[#433422] font-bold hover:text-[#78350f] border-[#78350f]">
                            {{ __('Manajemen Pesanan') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" class="text-[#433422] font-bold hover:text-[#78350f] border-[#78350f]">
                            {{ __('Riwayat Pembelian') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <a href="{{ route('cart.index') }}"
                   class="relative p-2 text-[#78350f] hover:bg-[#fef3c7] rounded-xl transition-all duration-200 border-2 border-transparent hover:border-[#78350f]">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-[10px] font-black leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-[#a16207] border-2 border-white rounded-full">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border-2 border-[#78350f] text-sm font-bold uppercase tracking-widest text-[#78350f] bg-white hover:bg-[#fef3c7] focus:outline-none transition duration-150 shadow-[3px_3px_0_0_rgba(120,53,15,1)]">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-[#fef3c7]">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="hover:bg-red-50">
                                <span class="text-red-700 font-bold">{{ __('Keluar') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 border-2 border-[#78350f] text-[#78350f] hover:bg-[#fef3c7] focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}"
         class="hidden sm:hidden border-t-4 border-[#78350f] bg-[#F9F7F2]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold text-[#433422]">
                {{ __('Beranda') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')" class="font-bold text-[#433422]">
                {{ __('Katalog Furniture') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="font-bold text-[#78350f]">
                {{ __('🛒 Keranjang') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
