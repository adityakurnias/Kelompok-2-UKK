@extends('layouts.app')
@section('title', 'Masuk - Preloved Market')

@push('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        background: var(--soft);
        padding: 3rem 0;
    }

    .auth-card {
        background: white;
        border-radius: 20px;
        border: 1.5px solid var(--border);
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(15,36,68,0.08);
    }

    .auth-side {
        background: var(--navy);
        padding: 3rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
        min-height: 420px;
    }

    .auth-side::before {
        content: '';
        position: absolute;
        bottom: -80px;
        right: -80px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(232,197,71,0.08);
    }

    .auth-side::after {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.03);
    }

    .auth-side .brand {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .auth-side .brand span { color: var(--accent); }

    .auth-side h3 {
        font-family: 'Playfair Display', serif;
        color: white;
        font-size: 1.4rem;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .auth-side p {
        color: rgba(255,255,255,0.55);
        font-size: 0.875rem;
        line-height: 1.7;
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
    }

    .auth-feature {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.85rem;
        position: relative;
        z-index: 1;
    }

    .auth-feature-icon {
        width: 32px;
        height: 32px;
        background: rgba(232,197,71,0.15);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .auth-feature span {
        color: rgba(255,255,255,0.75);
        font-size: 0.85rem;
    }

    .auth-form-wrap {
        padding: 2.75rem 2.5rem;
    }

    .auth-form-wrap h4 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--navy);
        font-size: 1.5rem;
        margin-bottom: 0.35rem;
    }

    .auth-form-wrap .subtitle {
        color: var(--muted);
        font-size: 0.875rem;
        margin-bottom: 2rem;
    }

    .form-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 0.4rem;
        letter-spacing: 0.2px;
    }

    .form-control {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.7rem 1rem;
        font-size: 0.9rem;
        color: var(--ink);
        background: var(--soft);
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: var(--navy);
        background: white;
        box-shadow: 0 0 0 3px rgba(15,36,68,0.08);
    }

    .form-control.is-invalid {
        border-color: #e53e3e;
        background: #fff5f5;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(229,62,62,0.1);
    }

    .invalid-feedback {
        font-size: 0.8rem;
        color: #e53e3e;
    }

    .input-icon-wrap {
        position: relative;
    }

    .input-icon-wrap .form-control {
        padding-left: 2.6rem;
    }

    .input-icon-wrap .input-icon {
        position: absolute;
        left: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 0.95rem;
        pointer-events: none;
    }

    .input-icon-wrap .toggle-password {
        position: absolute;
        right: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        cursor: pointer;
        font-size: 0.95rem;
        border: none;
        background: none;
        padding: 0;
        transition: color 0.2s;
    }

    .input-icon-wrap .toggle-password:hover { color: var(--navy); }

    .form-check-input {
        width: 16px;
        height: 16px;
        border: 1.5px solid var(--border);
        border-radius: 4px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--navy);
        border-color: var(--navy);
    }

    .form-check-label {
        font-size: 0.85rem;
        color: var(--muted);
        cursor: pointer;
    }

    .btn-auth {
        background: var(--navy);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.8rem;
        font-size: 0.95rem;
        font-weight: 600;
        width: 100%;
        transition: all 0.25s;
        letter-spacing: 0.2px;
    }

    .btn-auth:hover {
        background: var(--navy-mid);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(15,36,68,0.2);
    }

    .auth-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.5rem 0;
    }

    .auth-divider::before, .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .auth-divider span {
        font-size: 0.78rem;
        color: var(--muted);
        white-space: nowrap;
    }

    .auth-footer {
        text-align: center;
        font-size: 0.875rem;
        color: var(--muted);
    }

    .auth-footer a {
        color: var(--navy);
        font-weight: 600;
        text-decoration: none;
    }

    .auth-footer a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <div class="auth-card">
                    <div class="row g-0">
                        {{-- Side Panel --}}
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="auth-side h-100">
                                <div class="brand">Pre<span>loved</span></div>
                                <h3>Selamat datang kembali!</h3>
                                <p>Masuk dan lanjutkan perjalanan belanja preloved kamu bersama ribuan penjual terpercaya.</p>
                                <div class="auth-feature">
                                    <div class="auth-feature-icon"><i class="bi bi-shield-check"></i></div>
                                    <span>Transaksi aman & terlindungi</span>
                                </div>
                                <div class="auth-feature">
                                    <div class="auth-feature-icon"><i class="bi bi-tags"></i></div>
                                    <span>Ribuan produk pilihan</span>
                                </div>
                                <div class="auth-feature">
                                    <div class="auth-feature-icon"><i class="bi bi-star"></i></div>
                                    <span>Rating penjual terverifikasi</span>
                                </div>
                            </div>
                        </div>

                        {{-- Form --}}
                        <div class="col-lg-7">
                            <div class="auth-form-wrap">
                                <h4>Masuk ke Akun</h4>
                                <p class="subtitle">Belum punya akun? <a href="{{ route('register') }}" style="color:var(--navy);font-weight:600;text-decoration:none">Daftar gratis</a></p>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Alamat Email</label>
                                        <div class="input-icon-wrap">
                                            <i class="bi bi-envelope input-icon"></i>
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   id="email" name="email"
                                                   value="{{ old('email') }}"
                                                   placeholder="kamu@email.com"
                                                   required autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-icon-wrap">
                                            <i class="bi bi-lock input-icon"></i>
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   id="password" name="password"
                                                   placeholder="Masukkan password"
                                                   required>
                                            <button type="button" class="toggle-password" onclick="togglePass('password', this)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                            <label class="form-check-label" for="remember">Ingat saya</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-auth">
                                        Masuk <i class="bi bi-arrow-right ms-1"></i>
                                    </button>
                                </form>

                                <div class="auth-divider">
                                    <span>atau</span>
                                </div>

                                <div class="auth-footer">
                                    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePass(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endpush