@extends('layouts.app')
@section('title', 'Daftar - Preloved Market')

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
        padding: 2.5rem 2.75rem;
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
        margin-bottom: 1.75rem;
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
        font-size: 0.875rem;
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
        font-size: 0.9rem;
        pointer-events: none;
    }

    /* textarea icon fix */
    .input-icon-wrap.has-textarea .input-icon {
        top: 0.85rem;
        transform: none;
    }

    .input-icon-wrap .toggle-password {
        position: absolute;
        right: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        cursor: pointer;
        font-size: 0.9rem;
        border: none;
        background: none;
        padding: 0;
        transition: color 0.2s;
    }

    .input-icon-wrap .toggle-password:hover { color: var(--navy); }

    .section-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.25rem 0 1rem;
    }

    .section-divider::before, .section-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .section-divider span {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
        white-space: nowrap;
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

    .auth-footer {
        text-align: center;
        font-size: 0.875rem;
        color: var(--muted);
        margin-top: 1.25rem;
    }

    .auth-footer a {
        color: var(--navy);
        font-weight: 600;
        text-decoration: none;
    }

    .auth-footer a:hover { text-decoration: underline; }

    .password-strength {
        margin-top: 0.4rem;
        display: flex;
        gap: 4px;
    }

    .strength-bar {
        height: 3px;
        flex: 1;
        border-radius: 2px;
        background: var(--border);
        transition: background 0.3s;
    }

    .strength-bar.active-weak { background: #e53e3e; }
    .strength-bar.active-medium { background: #f6ad55; }
    .strength-bar.active-strong { background: #48bb78; }

    @media (max-width: 991px) {
        .auth-wrapper { padding: 2rem 0; align-items: flex-start; }
        .auth-form-wrap { padding: 2rem 1.5rem; }
    }

    @media (max-width: 576px) {
        .auth-form-wrap h4 { font-size: 1.3rem; }
        .auth-card { border-radius: 12px; }
    }
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="auth-card">
                    <div class="row g-0">
                        {{-- Side Panel --}}
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="auth-side h-100">
                                <div class="brand">Pre<span>loved</span></div>
                                <h3>Mulai perjalanan preloved kamu!</h3>
                                <p>Bergabung dengan jutaan pengguna yang sudah menemukan barang impian mereka.</p>
                                <div class="auth-feature">
                                    <div class="auth-feature-icon"><i class="bi bi-gift"></i></div>
                                    <span>Daftar 100% gratis</span>
                                </div>
                                <div class="auth-feature">
                                    <div class="auth-feature-icon"><i class="bi bi-bag-heart"></i></div>
                                    <span>Akses ke ribuan produk</span>
                                </div>
                                <div class="auth-feature">
                                    <div class="auth-feature-icon"><i class="bi bi-shop"></i></div>
                                    <span>Bisa jadi seller kapan saja</span>
                                </div>
                                <div class="auth-feature">
                                    <div class="auth-feature-icon"><i class="bi bi-headset"></i></div>
                                    <span>Dukungan pelanggan 24/7</span>
                                </div>
                            </div>
                        </div>

                        {{-- Form --}}
                        <div class="col-lg-8">
                            <div class="auth-form-wrap">
                                <h4>Buat Akun Baru</h4>
                                <p class="subtitle">Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--navy);font-weight:600;text-decoration:none">Masuk di sini</a></p>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="section-divider"><span>Informasi Pribadi</span></div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Nama Lengkap</label>
                                            <div class="input-icon-wrap">
                                                <i class="bi bi-person input-icon"></i>
                                                <input type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       id="name" name="name"
                                                       value="{{ old('name') }}"
                                                       placeholder="Nama lengkap kamu"
                                                       required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Alamat Email</label>
                                            <div class="input-icon-wrap">
                                                <i class="bi bi-envelope input-icon"></i>
                                                <input type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       id="email" name="email"
                                                       value="{{ old('email') }}"
                                                       placeholder="kamu@email.com"
                                                       required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Nomor Telepon</label>
                                            <div class="input-icon-wrap">
                                                <i class="bi bi-telephone input-icon"></i>
                                                <input type="text"
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       id="phone" name="phone"
                                                       value="{{ old('phone') }}"
                                                       placeholder="08xxxxxxxxxx"
                                                       required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="address" class="form-label">Alamat</label>
                                            <div class="input-icon-wrap has-textarea">
                                                <i class="bi bi-geo-alt input-icon"></i>
                                                <textarea class="form-control @error('address') is-invalid @enderror"
                                                          id="address" name="address"
                                                          rows="1"
                                                          placeholder="Alamat lengkap kamu"
                                                          required>{{ old('address') }}</textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-divider"><span>Keamanan Akun</span></div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-icon-wrap">
                                                <i class="bi bi-lock input-icon"></i>
                                                <input type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       id="password" name="password"
                                                       placeholder="Min. 8 karakter"
                                                       oninput="checkStrength(this.value)"
                                                       required>
                                                <button type="button" class="toggle-password" onclick="togglePass('password', this)">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="password-strength">
                                                <div class="strength-bar" id="bar1"></div>
                                                <div class="strength-bar" id="bar2"></div>
                                                <div class="strength-bar" id="bar3"></div>
                                                <div class="strength-bar" id="bar4"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <div class="input-icon-wrap">
                                                <i class="bi bi-lock-fill input-icon"></i>
                                                <input type="password"
                                                       class="form-control"
                                                       id="password_confirmation"
                                                       name="password_confirmation"
                                                       placeholder="Ulangi password"
                                                       required>
                                                <button type="button" class="toggle-password" onclick="togglePass('password_confirmation', this)">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-auth mt-4">
                                        Buat Akun <i class="bi bi-arrow-right ms-1"></i>
                                    </button>
                                </form>

                                <div class="auth-footer">
                                    Sudah punya akun? <a href="{{ route('login') }}">Masuk Sekarang</a>
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

function checkStrength(val) {
    const bars = [1,2,3,4].map(i => document.getElementById('bar' + i));
    bars.forEach(b => b.className = 'strength-bar');

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const cls = score <= 1 ? 'active-weak' : score <= 2 ? 'active-medium' : 'active-strong';
    for (let i = 0; i < score; i++) bars[i].classList.add(cls);
}
</script>
@endpush