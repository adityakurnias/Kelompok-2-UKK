<x-guest-layout>
    <h4 class="text-center fw-bold mb-4">Masuk ke Akun</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Ingat Saya</label>
        </div>

        <button type="submit" class="btn btn-custom w-100 py-2 mb-3">Login</button>

        <div class="text-center">
            <small>Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none">Daftar</a></small>
        </div>
    </form>
</x-guest-layout>