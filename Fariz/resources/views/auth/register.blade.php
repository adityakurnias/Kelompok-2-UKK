<x-guest-layout>
    <h4 style="font-size:1.2rem; font-weight:900; text-align:center; margin-bottom:1.5rem; color:white; text-transform:uppercase; letter-spacing:-1px;">Buat Akun Baru</h4>

    @if ($errors->any())
        <div style="background:rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color:#f87171; padding:0.75rem 1rem; border-radius:0.75rem; font-size:0.8rem; font-weight:700; margin-bottom:1rem;">
            <ul style="margin:0; padding-left:1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:1rem;">
        @csrf

        <div>
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-input" value="{{ old('name') }}" required autofocus>
            @error('name') <p style="color:#f87171; font-size:0.7rem; font-weight:700; margin-top:0.4rem;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
            @error('email') <p style="color:#f87171; font-size:0.7rem; font-weight:700; margin-top:0.4rem;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" required autocomplete="new-password">
            @error('password') <p style="color:#f87171; font-size:0.7rem; font-weight:700; margin-top:0.4rem;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-input" required>
        </div>

        <button type="submit" class="btn-primary" style="margin-top:0.5rem;">Daftar Sekarang</button>

        <hr class="divider">
        <p style="text-align:center; font-size:0.75rem; color:#64748b; font-weight:700;">
            Sudah punya akun? <a href="{{ route('login') }}" class="link-sky">Masuk</a>
        </p>
    </form>
</x-guest-layout>