<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buitenzorg TechSperts | Enterprise Hardware Solutions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .lenovo-red { color: #E2231A; }
        .lenovo-btn-red { background-color: #E2231A; }
        .lenovo-btn-red:hover { background-color: #ba1d15; }
        .product-card { border: 1px solid #e5e7eb; transition: box-shadow 0.3s ease; }
        .product-card:hover { box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); border-color: #d1d5db; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">
<nav class="bg-black text-white px-8 py-5 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <a href="{{ route('catalogue') }}">
                <h1 class="text-2xl font-extrabold tracking-tighter uppercase">
                    BUITENZORG <span class="lenovo-red">TECH</span>SPERTS
                </h1>
            </a>
        </div>

        <div class="flex items-center space-x-8 text-[12px] font-bold uppercase tracking-wide">
            <div class="flex items-center bg-gray-900 border border-gray-700 rounded-md px-2 py-1">
                <button onclick="setLanguage('en')" id="btn-en" class="text-red-500 px-1 transition">EN</button>
                <span class="text-gray-600 px-1">|</span>
                <button onclick="setLanguage('id')" id="btn-id" class="text-gray-400 px-1 transition">ID</button>
            </div>

            <a href="{{ route('dashboard') }}" class="lang-target hover:text-red-500 transition" data-en="Home" data-id="Beranda">Home</a>
            
            <a href="{{ route('catalogue') }}" class="lang-target hover:text-red-500 transition" data-en="Catalogue" data-id="Katalog">Catalogue</a>
            
            @auth
               @auth
   <div class="flex items-center space-x-6">
    <a href="{{ route('orders.index') }}" class="hover:scale-110 transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
    </a>

    <span class="text-gray-400 font-normal normal-case text-xs">
        Logged in as: <strong>{{ Auth::user()->name }}</strong>
    </span>
    </div>
        
        @if(Auth::user()->is_admin)
            <a href="{{ route('admin.add') }}" 
               class="lang-target hover:text-red-500 transition uppercase font-bold"
               data-en="Manage Inventory" data-id="Kelola Inventaris">
                Manage Inventory
            </a>

            <a href="{{ route('admin.shipping') }}" 
               class="lang-target hover:text-red-500 transition uppercase font-bold"
               data-en="Manage Shipping" data-id="Kelola Pengiriman">
                Manage Shipping
            </a>
        @endif
    </div>

                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="lang-target text-red-500 hover:text-white transition" data-en="Sign Out" data-id="Keluar">Sign Out</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="lang-target hover:text-gray-300 transition" data-en="Log In" data-id="Masuk">Log In</a>
                <a href="{{ route('register') }}" class="lang-target lenovo-btn-red text-white px-4 py-2 transition" data-en="Register" data-id="Daftar">Register</a>
            @endauth
        </div>
    </div>
</nav>

<div class="bg-gray-50 border-b border-gray-200 py-3 px-8">
    <div class="max-w-7xl mx-auto text-[11px] text-gray-500 font-medium uppercase tracking-wider">
        <a href="{{ route('dashboard') }}" class="lang-target hover:text-black transition" data-en="Home" data-id="Beranda">Home</a> / LAPTOPS 
    </div>
</div>

    <header class="max-w-7xl mx-auto py-12 px-8 text-center md:text-left">
        <h2 class="lang-target text-4xl font-bold tracking-tight text-gray-900 uppercase" 
            data-en="Explore Our Catalogue" 
            data-id="Jelajahi Katalog Kami">
            Explore Our Catalogue
        </h2>
        <div class="mt-4 space-y-1">
            <p class="lang-target text-red-600 font-bold tracking-widest text-xs uppercase italic"
               data-en="We sell professional-grade laptops, workstations and personal computers" 
               data-id="Kami menjual laptop kelas profesional, workstation, dan komputer pribadi">
               We sell professional-grade laptops, workstations and personal computers
            </p>
            <p class="lang-target text-sm text-gray-500 font-medium"
               data-en="Reliable, Dependable, and ready for work."
               data-id="Andal, Terpercaya, dan siap untuk bekerja.">
               Reliable, Dependable, and ready for work.
            </p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto pb-24 px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($laptops as $laptop)
            <div class="product-card bg-white flex flex-col h-full">
             <div class="h-64 bg-gray-50 flex items-center justify-center p-4 overflow-hidden">
    @if($laptop->image)
        <img src="{{ asset($laptop->image) }}" 
             alt="{{ $laptop->model }}" 
             class="h-full w-full object-contain transition-transform duration-500 hover:scale-110">
    @endif
</div>
                <div class="p-6">
                    <h3 class="text-xl font-bold uppercase">{{ $laptop->model }}</h3>
                    <p class="text-2xl font-black mt-4">Rp {{ number_format($laptop->price, 0, ',', '.') }}</p>
                    
                    <a href="{{ route('checkout', $laptop->id) }}" 
                       class="lang-target mt-6 block text-center lenovo-btn-red text-white py-3 text-[10px] font-bold uppercase tracking-widest"
                       data-en="View Details" 
                       data-id="Lihat Detail">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <script>
        function setLanguage(lang) {
            const targets = document.querySelectorAll('.lang-target');
            targets.forEach(el => {
                const translation = el.getAttribute(`data-${lang}`);
                if (translation) { el.innerText = translation; }
            });

            const btnEn = document.getElementById('btn-en');
            const btnId = document.getElementById('btn-id');
            if (lang === 'en') {
                btnEn.classList.replace('text-gray-400', 'text-red-500');
                btnId.classList.replace('text-red-500', 'text-gray-400');
            } else {
                btnId.classList.replace('text-gray-400', 'text-red-500');
                btnEn.classList.replace('text-red-500', 'text-gray-400');
            }
        }
    </script>
</body>
</html>