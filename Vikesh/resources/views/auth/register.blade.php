<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buitenzorg TechSperts | Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .lenovo-red { color: #E2231A; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col">

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
                <a href="{{ route('catalogue') }}" class="hover:text-red-500 transition">Catalogue</a>
                <a href="{{ route('login') }}" class="hover:text-gray-400 transition">Log In</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full bg-white border border-gray-200 shadow-2xl p-10">
            <h2 class="text-3xl font-black tracking-tighter uppercase mb-6">CREATE <span class="lenovo-red">ACCOUNT</span></h2>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1">Full Name</label>
                    <input type="text" name="name" required autofocus class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:border-red-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:border-red-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:border-red-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:border-red-500 outline-none">
                </div>

                <button type="submit" class="w-full bg-black text-white font-bold py-4 text-[11px] uppercase tracking-[0.3em] hover:bg-gray-900 transition-all">
                    Register Now
                </button>
            </form>
        </div>
    </main>
</body>
</html>