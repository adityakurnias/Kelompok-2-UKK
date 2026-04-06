<x-guest-layout>
    <h4 style="font-size:1.2rem; font-weight:900; text-align:center; margin-bottom:1.5rem; color:white; text-transform:uppercase; letter-spacing:-1px;">Masuk ke Akun</h4>

    @if (session('status'))
        <div style="background:rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color:#4ade80; padding:0.75rem 1rem; border-radius:0.75rem; font-size:0.8rem; font-weight:700; margin-bottom:1rem;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:1rem;">
        @csrf
        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" required autofocus value="{{ old('email') }}">
            @error('email') <p style="color:#f87171; font-size:0.7rem; font-weight:700; margin-top:0.4rem;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" required>
            @error('password') <p style="color:#f87171; font-size:0.7rem; font-weight:700; margin-top:0.4rem;">{{ $message }}</p> @enderror
        </div>

        <div style="display:flex; align-items:center; gap:0.5rem;">
            <input type="checkbox" name="remember" id="remember" style="accent-color:#0ea5e9; width:1rem; height:1rem;">
            <label for="remember" style="font-size:0.75rem; font-weight:700; color:#64748b;">Ingat Saya</label>
        </div>

        <button type="submit" class="btn-primary" style="margin-top:0.5rem;">Masuk</button>

        <hr class="divider">
        <p style="text-align:center; font-size:0.75rem; color:#64748b; font-weight:700;">
            Belum punya akun? <a href="{{ route('register') }}" class="link-sky">Daftar Sekarang</a>
        </p>
    </form>
</x-guest-layout>