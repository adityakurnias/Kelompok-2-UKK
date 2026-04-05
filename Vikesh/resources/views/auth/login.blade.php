<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buitenzorg TechSperts | Member Login</title>
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
                <a href="{{ route('catalogue') }}" class="lang-target hover:text-red-500 transition" data-en="Catalogue" data-id="Katalog">Catalogue</a>
                <a href="{{ route('register') }}" class="lang-target bg-red-600 text-white px-4 py-2 transition" data-en="Join Now" data-id="Daftar Sekarang">Join Now</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full bg-white border border-gray-200 shadow-2xl p-10">
            
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-black tracking-tighter uppercase">
                    MEMBER <span class="lenovo-red">LOGIN</span>
                </h2>
                <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-widest">
                    Secure Enterprise Access
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                        class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-red-500 transition-colors">
                    @if($errors->has('email'))
                        <p class="text-red-600 text-[10px] mt-1 uppercase font-bold">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500 mb-1">Password</label>
                    <input id="password" type="password" name="password" required 
                        class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-red-500 transition-colors">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                        <span class="ms-2 text-[10px] font-bold uppercase text-gray-500">Remember Me</span>
                    </label>
                </div>

                <div class="pt-4 space-y-4">
                    <button type="submit" class="w-full bg-black text-white font-bold py-4 text-[11px] uppercase tracking-[0.3em] hover:bg-gray-900 transition-all shadow-lg">
                        Sign In
                    </button>
                    
                    <div class="text-center">
                        <a href="{{ route('register') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-red-500 transition">
                            No account? Create one here
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-8 px-8">
        <div class="max-w-7xl mx-auto flex justify-center text-gray-400 text-[10px] font-bold uppercase tracking-widest">
            &copy; 2026 BUITENZORG TECHSPERTS.
        </div>
    </footer>
</body>
</html>