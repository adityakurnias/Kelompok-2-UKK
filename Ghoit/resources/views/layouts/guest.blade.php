<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#fdfdfd]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-4">
                <style>
                    @keyframes rgbGlow {
                        0% { color: #ff0000; text-shadow: 0 0 10px #ff0000, 0 0 20px #ff0000; }
                        33% { color: #00ff00; text-shadow: 0 0 10px #00ff00, 0 0 20px #00ff00; }
                        66% { color: #0000ff; text-shadow: 0 0 10px #0000ff, 0 0 20px #0000ff; }
                        100% { color: #ff0000; text-shadow: 0 0 10px #ff0000, 0 0 20px #ff0000; }
                    }
                    .rgb-glow-text {
                        animation: rgbGlow 3s infinite linear;
                    }
                </style>
                <a href="/" class="flex flex-col items-center">
                    <span class="text-4xl font-black tracking-tighter italic rgb-glow-text">ATK<span class="opacity-90">Ghoits</span></span>
                    <div class="h-1 w-16 bg-gradient-to-r from-red-500 via-green-500 to-blue-500 mt-2 rounded-full animate-pulse"></div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white border border-gray-100 shadow-2xl shadow-blue-500/5 overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>

            <p class="mt-8 text-sm text-gray-400 font-medium">© {{ date('Y') }} ATK Store - Your Stationery Solution</p>
        </div>
    </body>
</html>
