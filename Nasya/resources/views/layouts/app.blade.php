<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FurniSpace') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700,900|instrument-sans:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
                background-color: #F9F7F2;
            }
            h1, h2, h3, .font-serif {
                font-family: 'Playfair Display', serif;
            }

            /* Tombol WhatsApp Styles */
            .wa-float {
                position: fixed;
                bottom: 40px;
                right: 40px;
                background-color: #25d366;
                color: #FFF !important; /* Memaksa warna tetap putih */
                border-radius: 50px;
                text-align: center;
                padding: 12px 25px;
                box-shadow: 2px 5px 15px rgba(0,0,0,0.2);
                z-index: 10000;
                text-decoration: none !important;
                display: flex;
                align-items: center;
                gap: 12px;
                transition: all 0.3s ease;
            }
            .wa-float:hover {
                background-color: #128c7e;
                transform: scale(1.05) translateY(-5px);
                color: #FFF !important;
            }
            .my-float {
                font-size: 28px;
            }
            .wa-text {
                font-weight: 700;
                font-size: 15px;
            }
            @keyframes pulse-green {
                0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7); }
                70% { box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
                100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
            }
            .wa-float {
                animation: pulse-green 2s infinite;
            }

            /* Responsif untuk Mobile */
            @media screen and (max-width: 768px) {
                .wa-text { display: none; } /* Hanya tampilkan icon di HP agar tidak sempit */
                .wa-float { padding: 15px; right: 20px; bottom: 20px; border-radius: 50%; }
            }
        </style>
    </head>
    <body class="antialiased text-[#433422]">
        <div class="min-h-screen">
            <div class="sticky top-0 z-50">
                @include('layouts.navigation')
            </div>

            @isset($header)
                <header class="bg-white/50 backdrop-blur-md border-b border-[#eaddcf]">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-4">
                            <div class="w-1.5 h-8 bg-[#78350f] rounded-full"></div>
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <main>
                <div class="py-6">
                    {{ $slot }}
                </div>
            </main>

            <footer class="py-10 text-center border-t border-[#eaddcf] mt-12">
                <p class="text-[10px] font-bold tracking-[0.3em] text-[#a16207] uppercase">
                    &copy; {{ date('Y') }} FurniSpace — Crafted with Elegance
                </p>
            </footer>
        </div>

        <a href="https://wa.me/628872323787?text=Halo%20FurniSpace,%20saya%20ingin%20tanya%20tentang%20furniture."
           class="wa-float"
           target="_blank"
           rel="noopener noreferrer">
            <i class="fab fa-whatsapp my-float"></i>
            <span class="wa-text">Chat Customer Service</span>
        </a>
    </body>
</html>
