<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h2>
        <p class="text-gray-500 text-sm mt-1">Bergabunglah dengan ATK Store untuk kemudahan belanja Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1 ml-1">Nama Lengkap</label>
            <input id="name" class="block w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50/50 text-gray-800 focus:border-blue-500 focus:ring-blue-500 transition-all duration-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Budi Santoso" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1 ml-1">Alamat Email</label>
            <input id="email" class="block w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50/50 text-gray-800 focus:border-blue-500 focus:ring-blue-500 transition-all duration-200" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="budi@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1 ml-1">Kata Sandi</label>
            <input id="password" class="block w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50/50 text-gray-800 focus:border-blue-500 focus:ring-blue-500 transition-all duration-200"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1 ml-1">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" class="block w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50/50 text-gray-800 focus:border-blue-500 focus:ring-blue-500 transition-all duration-200"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transform transition-all active:scale-[0.98] duration-200">
                Daftar Akun
            </button>
        </div>

        <div class="text-center pt-2">
            <p class="text-sm text-gray-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline decoration-2 underline-offset-4">Masuk</a></p>
        </div>
    </form>
</x-guest-layout>
