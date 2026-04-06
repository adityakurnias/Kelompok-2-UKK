<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Instrument Sans', sans-serif !important; background-color: #0f172a; color: #f8fafc; }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-[#0f172a]">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-[#1e293b]/80 backdrop-blur-md border-b border-white/5 shadow-xl">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                <div class="py-4">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>