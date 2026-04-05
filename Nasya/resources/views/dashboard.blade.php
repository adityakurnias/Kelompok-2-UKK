<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-amber-900 leading-tight">
            {{ __('Dashboard Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F9F7F2] min-h-screen"> <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm p-10 mb-8 border border-amber-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-amber-700"></div>

                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="h-24 w-24 bg-amber-50 rounded-2xl flex items-center justify-center text-5xl shadow-inner border border-amber-100">
                        🛋️
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-serif text-amber-900 leading-tight">
                            Halo, <span class="font-bold">{{ Auth::user()->name }}</span>!
                        </h1>
                        <p class="text-amber-700/60 font-medium italic mt-2 text-lg">
                            Siap untuk mempercantik sudut rumah Anda hari ini?
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-amber-50 group hover:shadow-md hover:border-amber-200 transition-all">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-amber-900 rounded-xl text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h4 class="font-bold text-amber-900 text-xl">Koleksi FurniSpace</h4>
                    </div>
                    <p class="text-amber-800/70 mb-8 leading-relaxed">Jelajahi berbagai pilihan furnitur mulai dari minimalis hingga klasik yang dikurasi khusus untuk kenyamanan Anda.</p>
                    <a href="{{ url('/shop') }}" class="inline-block w-full text-center bg-amber-800 text-white font-bold py-4 rounded-2xl hover:bg-amber-900 transition-all shadow-lg shadow-amber-200 uppercase tracking-widest text-xs">
                        Lihat Katalog Produk
                    </a>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-8 border border-amber-50 group hover:shadow-md hover:border-amber-200 transition-all">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-amber-100 rounded-xl text-amber-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h4 class="font-bold text-amber-900 text-xl">Akun Saya</h4>
                    </div>
                    <div class="bg-amber-50/50 rounded-2xl p-4 mb-8 space-y-3">
                        <p class="text-sm font-medium text-amber-800 flex justify-between">
                            <span>Email:</span>
                            <span class="font-bold">{{ Auth::user()->email }}</span>
                        </p>
                        <p class="text-sm font-medium text-amber-800 flex justify-between">
                            <span>Status:</span>
                            <span class="bg-amber-200 text-amber-800 px-3 py-0.5 rounded-full text-[10px] font-black uppercase tracking-tighter">Gold Member</span>
                        </p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="inline-block w-full text-center border-2 border-amber-800 text-amber-800 font-bold py-4 rounded-2xl hover:bg-amber-50 transition-all uppercase tracking-widest text-xs">
                        Pengaturan Profil
                    </a>
                </div>
            </div>

            <div class="mt-10 bg-amber-900 rounded-[2rem] p-10 text-white flex flex-col md:flex-row items-center justify-between shadow-xl relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/pinstriped-suit.png');"></div>

                <div class="relative z-10">
                    <span class="inline-block bg-amber-700 text-amber-200 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest mb-4">Limited Offer</span>
                    <h3 class="text-3xl font-serif mb-2">Potongan Perdana 10%</h3>
                    <p class="text-amber-200/80 font-medium">Gunakan kode khusus member baru: <span class="text-white font-bold border-b border-dashed border-amber-400">FURNINEW26</span></p>
                </div>
                <div class="mt-8 md:mt-0 relative z-10">
                    <div class="text-6xl filter drop-shadow-lg">✨</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
