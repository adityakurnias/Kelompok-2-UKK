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
                <a href="/" class="flex flex-col items-center">
                    <span class="text-3xl font-bold tracking-tighter text-blue-900 italic">ATK<span class="text-blue-500">Store</span></span>
                    <div class="h-1 w-12 bg-blue-500 mt-1 rounded-full"></div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white border border-gray-100 shadow-2xl shadow-blue-500/5 overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>

            <p class="mt-8 text-sm text-gray-400 font-medium">© {{ date('Y') }} ATK Store - Your Stationery Solution</p>
        </div>
    </body>
</html>
