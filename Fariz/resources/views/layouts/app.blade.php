<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Fariz Net') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --bg-dark: #0f172a;
                --bg-card: #1e293b;
                --accent: #0ea5e9;
            }
            body, html {
                font-family: 'Instrument Sans', sans-serif !important;
                background-color: var(--bg-dark) !important;
                color: #f8fafc !important;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen" style="background-color: #0f172a;">
            @include('layouts.navigation')

            @isset($header)
                <header style="background: rgba(15,23,42,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.07);">
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