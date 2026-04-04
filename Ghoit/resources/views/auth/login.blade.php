<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Welcome Back</h2>
        <p class="text-gray-500 text-sm mt-1">Please enter your credentials to continue shopping.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1 ml-1">Email Address</label>
            <input id="email" class="block w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50/50 text-gray-800 focus:border-blue-500 focus:ring-blue-500 transition-all duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1 ml-1">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-400">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-blue-500 hover:text-blue-600 transition-colors" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>

            <input id="password" class="block w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50/50 text-gray-800 focus:border-blue-500 focus:ring-blue-500 transition-all duration-200"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-200 text-blue-600 focus:ring-blue-500" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-gray-500 font-medium select-none">{{ __('Remember me') }}</label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transform transition-all active:scale-[0.98] duration-200">
                Log In
            </button>
        </div>

        <div class="text-center pt-2">
            <p class="text-sm text-gray-500">Don't have an account? <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline decoration-2 underline-offset-4">Sign Up</a></p>
        </div>
    </form>
</x-guest-layout>
