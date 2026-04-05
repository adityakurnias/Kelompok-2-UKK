<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buitenzorg TechSperts | Premium Business Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .lenovo-red { color: #E2231A; }
        .lenovo-btn-red { background-color: #E2231A; }
        .lenovo-btn-red:hover { background-color: #ba1d15; }
        
        .hero-bg-overlay {
            background-image: linear-gradient(to right, rgba(255,255,255,0.95) 35%, rgba(255,255,255,0.1) 100%), 
                              url('https://p1-ofp.static.pub/ShareResource/na/products/thinkpad/thinkpad-t-series/images/lenovo-thinkpad-t-series-feature-1.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    <nav class="bg-black text-white px-8 py-5 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <a href="{{ route('dashboard') }}">
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

                <a href="{{ route('catalogue') }}" class="lang-target hover:text-gray-300 transition" data-en="Catalogue" data-id="Katalog">Catalogue</a>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="lang-target text-red-500" data-en="Home" data-id="Beranda">Home</a>
                    <span class="text-gray-400 font-normal normal-case">Logged in as: <strong>{{ Auth::user()->name }}</strong></span>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="lang-target text-red-500 hover:text-white transition" data-en="Sign Out" data-id="Keluar">Sign Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="lang-target hover:text-gray-300 transition" data-en="Log In" data-id="Masuk">Log In</a>
                    <a href="{{ route('register') }}" class="lang-target lenovo-btn-red text-white px-4 py-2 transition" data-en="Register" data-id="Daftar">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero-bg-overlay py-28 px-8 border-b border-gray-100 relative">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center relative z-10">
            <div class="md:w-1/2 space-y-6">
                <span class="lang-target text-red-600 font-bold tracking-widest text-xs uppercase italic"
                      data-en="Professional Grade Hardware" data-id="Perangkat Keras Kelas Profesional">
                      Professional Grade Hardware
                </span>
                <h2 class="lang-target text-7xl font-extrabold tracking-tight leading-[0.9] text-gray-900"
                    data-en="Professional Tech for Everyone." data-id="Teknologi Profesional Untuk Semua orang.">
                    Professional <br>Tech for <br><span class="lenovo-red">Everyone.</span>
                </h2>
                <p class="lang-target text-lg text-gray-800 font-medium max-w-md mt-4"
                   data-en="Reliable, business-grade laptops and workstations engineered for the most demanding environments."
                   data-id="Laptop dan workstation kelas bisnis yang andal, dirancang untuk lingkungan kerja yang paling menuntut.">
                    Reliable, business-grade laptops and workstations engineered for the most demanding environments.
                </p>
                <div class="pt-8 flex space-x-4">
                    <a href="{{ route('catalogue') }}" class="lang-target lenovo-btn-red text-white px-10 py-4 font-bold uppercase text-xs tracking-widest shadow-2xl transition-transform hover:scale-105"
                       data-en="Browse Inventory" data-id="Lihat Katalog">
                        Browse Catalogue
                    </a>
                </div>
            </div>
            
            <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center">
                <img src="https://p2-ofp.static.pub/fes/cms/2022/03/17/99k6m500609i70u6pxkujy2mcl56t2253326.png" 
                     class="w-full h-auto drop-shadow-2xl max-w-lg select-none" 
                     alt="">
            </div>
        </div>
    </section>

    <section class="py-24 px-8 bg-white">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-16">
            <div class="border-t-4 border-black pt-8">
                <h4 class="lang-target text-sm font-black uppercase mb-4 tracking-widest" data-en="01. Guaranteed Quality" data-id="01. Kualitas Terjamin">01. Guaranteed Quality</h4>
                <p class="lang-target text-sm text-gray-500 leading-relaxed" 
                   data-en="Ex units from major corporations, ensuring hardware has been maintained by professionals."
                   data-id="Unit eks perusahaan besar, memastikan perangkat keras telah dirawat oleh profesional.">
                   Ex units from major corporations, ensuring hardware has been maintained by professionals.
                </p>
            </div>
            <div class="border-t-4 border-red-600 pt-8">
                <h4 class="lang-target text-sm font-black uppercase mb-4 tracking-widest" data-en="02. Top Quality Control" data-id="02. Kontrol Kualitas Terjamin">02. Top Quality Control</h4>
                <p class="lang-target text-sm text-gray-500 leading-relaxed"
                   data-en="Strict  inspection including battery health and thermal stress testing."
                   data-id="Inspeksi ketat  termasuk kesehatan baterai dan pengujian tekanan termal.">
                   Strict  inspection including battery health and thermal stress testing.
                </p>
            </div>
            <div class="border-t-4 border-black pt-8">
                <h4 class="lang-target text-sm font-black uppercase mb-4 tracking-widest" data-en="03. Offline Troubleshooting" data-id="03. Bantuan Offline">03. Offline Troubleshooting</h4>
                <p class="lang-target text-sm text-gray-500 leading-relaxed"
                   data-en="Local support for our customers in Sentul, At Main Street Jakarta-Bogor KM.50."
                   data-id="Dukungan lokal untuk pelanggan kami di Bogor, di Jalan Raya Jakarta-Bogor Km.50.">
                   Local support for our customers in Sentul, at Main Street Jakarta-Bogor KM.50
                </p>
            </div>
        </div>
    </section>

    <footer class="bg-gray-50 py-12 px-8 border-t border-gray-100 text-center md:text-left">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em]">
            <p>&copy; 2026 BUITENZORG TECHSPERTS</p>
            <div class="flex space-x-8 mt-4 md:mt-0">
                <a href="#" class="lang-target hover:text-black transition" data-en="Location" data-id="Lokasi">Location</a>
                <a href="#" class="lang-target hover:text-black transition" data-en="WhatsApp" data-id="WhatsApp">WhatsApp</a>
            </div>
        </div>
    </footer>

    <script>
        function setLanguage(lang) {
            const targets = document.querySelectorAll('.lang-target');
            targets.forEach(el => {
                const translation = el.getAttribute(`data-${lang}`);
                if (translation) {
                    if (el.tagName === 'INPUT') { el.value = translation; }
                    else { el.innerText = translation; }
                }
            });

            // Switcher UI Styling logic fixed
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