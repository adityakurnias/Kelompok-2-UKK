<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Buitenzorg TechSperts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-100 antialiased">

    <nav class="bg-black text-white px-8 py-5 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('catalogue') }}">
                <h1 class="text-2xl font-extrabold tracking-tighter uppercase">
                    BUITENZORG <span class="text-red-600">TECH</span>SPERTS
                </h1>
            </a>
            <div class="flex items-center space-x-6 text-[10px] font-bold uppercase tracking-widest">
                <a href="{{ route('catalogue') }}" class="hover:text-red-500 transition">Catalogue</a>
                <span class="text-gray-500">User: {{ Auth::user()->name }}</span>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-12 px-6">
        <h2 class="text-3xl font-black uppercase tracking-tighter mb-8 border-l-8 border-red-600 pl-4">
            My <span class="text-red-600">Purchase</span> History
        </h2>

        @if($orders->isEmpty())
            <div class="bg-white p-16 text-center shadow-sm border border-gray-200">
                <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">No orders placed yet</p>
                <a href="{{ route('catalogue') }}" class="mt-4 inline-block bg-black text-white px-6 py-2 text-[10px] font-black uppercase">Browse Items</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                <div class="bg-white border border-gray-200 shadow-sm overflow-hidden flex flex-col md:flex-row">
                    <div class="w-full md:w-48 bg-gray-50 flex items-center justify-center p-4">
                        <img src="{{ asset($order->laptop->image) }}" class="max-h-24 w-auto object-contain">
                    </div>

                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold text-red-600 uppercase tracking-widest">Order #00{{ $order->id }}</span>
                                <h3 class="text-xl font-black uppercase text-gray-900">{{ $order->laptop->model }}</h3>
                                <p class="text-gray-500 text-[10px] font-bold uppercase mt-1">Quantity: {{ $order->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black">Rp {{ number_format($order->laptop->price * $order->quantity, 0, ',', '.') }}</p>
                                
                                <span class="inline-block mt-2 px-3 py-1 text-[9px] font-black uppercase border-2
                                    {{ $order->status == 'pending' ? 'border-yellow-500 text-yellow-600 bg-yellow-50' : '' }}
                                    {{ $order->status == 'shipped' ? 'border-blue-600 text-white bg-blue-600' : '' }}
                                    {{ $order->status == 'completed' ? 'border-green-600 text-green-700 bg-green-50' : '' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-[10px] font-bold uppercase">
                            <div class="text-gray-400">
                                Shipping to: <span class="text-gray-800">{{ $order->alamat }}</span>
                            </div>
                            <div class="text-gray-400">
                                Method: <span class="text-gray-800">{{ $order->payment_method }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>