<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil - Toko ATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .checkmark-check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
        }
        @keyframes stroke {
            100% { stroke-dashoffset: 0; }
        }
        @keyframes scale {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .animate-bounce-short {
            animation: scale 0.5s ease-in-out 0.8s forwards;
        }
    </style>
</head>
<body class="antialiased bg-[#fdfdfd] text-gray-900 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 h-20 flex items-center shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex flex-col">
                <span class="text-xl font-extrabold tracking-tighter text-blue-900 leading-none">ATK<span class="text-blue-500">Checkout</span></span>
            </a>
            <span class="text-[10px] font-bold text-green-500 uppercase tracking-widest bg-green-50 px-3 py-1.5 rounded-lg border border-green-100">Selesai</span>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full bg-white rounded-[3rem] p-10 sm:p-16 shadow-2xl shadow-gray-200/50 border border-gray-100 text-center animate-bounce-short">
            
            <!-- Animated Checkmark -->
            <div class="flex justify-center mb-10">
                <svg class="w-20 h-20 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path class="checkmark-check" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                </svg>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                Pembayaran Sukses!
            </h1>
            
            <p class="text-lg text-gray-500 font-medium leading-relaxed mb-10 max-w-sm mx-auto">
                <span class="block mb-2 font-bold text-gray-700">Terimakasih telah order di toko kami.</span>
                Pesanan anda akan kami proses secepatnya.
            </p>

            <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100 mb-10 text-left">
                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                    <span class="text-xs font-black uppercase tracking-widest text-gray-400">Order ID</span>
                    <span class="font-bold text-gray-900">#{{ $transaction->id }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="font-medium text-gray-500">Total Dibayar</span>
                    <span class="font-black text-blue-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('dashboard') }}" class="py-4 px-8 bg-blue-600 text-white rounded-2xl font-bold tracking-tight shadow-xl shadow-blue-600/30 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 text-center">
                    Masuk ke Dashboard
                </a>
                <a href="{{ route('home') }}" class="py-4 px-8 bg-gray-100 text-gray-700 rounded-2xl font-bold tracking-tight hover:bg-gray-200 transition-all text-center">
                    Lanjut Belanja
                </a>
            </div>
            
        </div>
    </main>
</body>
</html>
