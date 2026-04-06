@extends('layouts.app')

@section('title', 'Beranda - Preloved Market')

@push('styles')
<style>
    /* ── HERO ── */
    .hero {
        background: var(--navy);
        position: relative;
        overflow: hidden;
        padding: 5rem 0 4rem;
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 80% 50%, rgba(232,197,71,0.12) 0%, transparent 70%),
            radial-gradient(ellipse 40% 60% at 10% 80%, rgba(26,58,107,0.8) 0%, transparent 60%);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(232,197,71,0.15);
        border: 1px solid rgba(232,197,71,0.3);
        color: var(--accent);
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        margin-bottom: 1.5rem;
    }

    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        font-weight: 700;
        color: white;
        line-height: 1.15;
        margin-bottom: 1.25rem;
        letter-spacing: -0.5px;
    }

    .hero h1 em {
        font-style: normal;
        color: var(--accent);
    }

    .hero p {
        color: rgba(255,255,255,0.65);
        font-size: 1.05rem;
        line-height: 1.75;
        max-width: 480px;
        margin-bottom: 2rem;
    }

    .hero-cta {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-hero-primary {
        background: var(--accent);
        color: var(--navy);
        font-weight: 700;
        border: none;
        border-radius: 10px;
        padding: 0.8rem 1.75rem;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-hero-primary:hover {
        background: #f5d45a;
        color: var(--navy);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(232,197,71,0.35);
    }

    .btn-hero-ghost {
        background: transparent;
        color: white;
        font-weight: 500;
        border: 1.5px solid rgba(255,255,255,0.3);
        border-radius: 10px;
        padding: 0.8rem 1.75rem;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-hero-ghost:hover {
        border-color: white;
        color: white;
        background: rgba(255,255,255,0.08);
    }

    .hero-stats {
        display: flex;
        gap: 2rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    .stat-item span {
        display: block;
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.4rem, 4vw, 1.8rem);
        font-weight: 700;
        color: var(--accent);
    }

    .stat-item small {
        color: rgba(255,255,255,0.5);
        font-size: 0.75rem;
        font-weight: 500;
    }

    .hero-image-wrap {
        position: relative;
        display: flex;
        justify-content: center;
        perspective: 1000px;
    }

    .hero-img-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px;
        overflow: hidden;
        width: 100%;
        max-width: 480px;
        transform: rotateY(-5deg) rotateX(5deg);
        box-shadow: 20px 20px 60px rgba(0,0,0,0.4);
        transition: all 0.5s ease;
    }

    .hero-img-card:hover { transform: none; }

    .hero-img-card img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        opacity: 0.9;
    }

    .hero-float-badge {
        position: absolute;
        bottom: 30px;
        left: -20px;
        background: white;
        border-radius: 16px;
        padding: 0.85rem 1.25rem;
        box-shadow: 0 12px 40px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--navy);
        z-index: 2;
    }

    .hero-float-badge i {
        font-size: 1.4rem;
        color: var(--accent);
    }

    /* ── CATEGORIES ── */
    .section-label {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 0.5rem;
        display: block;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.6rem, 3vw, 2.2rem);
        color: var(--navy);
        font-weight: 700;
        margin-bottom: 0;
    }

    .section-header {
        margin-bottom: 2.5rem;
    }

    .cat-chip {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        text-decoration: none;
        color: var(--ink);
        transition: all 0.22s;
        margin-bottom: 0.75rem;
    }

    .cat-chip:hover {
        border-color: var(--navy);
        background: var(--navy);
        color: white;
        transform: translateX(4px);
    }

    .cat-chip:hover .cat-icon { background: rgba(255,255,255,0.15); color: var(--accent); }
    .cat-chip:hover .cat-name { color: white; }
    .cat-chip:hover .cat-arrow { opacity: 1; }

    .cat-icon {
        width: 40px;
        height: 40px;
        background: var(--soft);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: var(--navy);
        flex-shrink: 0;
        transition: all 0.22s;
    }

    .cat-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--ink);
        transition: color 0.22s;
    }

    .cat-arrow {
        margin-left: auto;
        opacity: 0.3;
        font-size: 0.85rem;
        transition: opacity 0.22s;
    }

    /* ── PRODUCTS ── */
    .products-section {
        padding: 4.5rem 0;
        background: var(--soft);
    }

    /* Section titles and headers are already global or specific enough */

    /* ── STEPS ── */
    .steps-section { padding: 4.5rem 0; background: white; }

    .step-card {
        position: relative;
        padding: 2rem 1.5rem;
        border-radius: 14px;
        background: var(--soft);
        border: 1.5px solid var(--border);
        text-align: center;
        transition: all 0.25s;
        height: 100%;
    }

    .step-card:hover {
        border-color: var(--navy);
        transform: translateY(-4px);
        box-shadow: 0 12px 36px rgba(15,36,68,0.1);
    }

    .step-num {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        color: rgba(15,36,68,0.07);
        line-height: 1;
        position: absolute;
        top: 0.75rem;
        right: 1rem;
    }

    .step-icon {
        width: 52px;
        height: 52px;
        background: var(--navy);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.1rem;
        font-size: 1.3rem;
        color: var(--accent);
    }

    .step-card h5 {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        color: var(--navy);
        font-size: 1.05rem;
        margin-bottom: 0.6rem;
    }

    .step-card p {
        font-size: 0.85rem;
        color: var(--muted);
        line-height: 1.65;
        margin: 0;
    }

    @media (max-width: 991px) {
        .hero { padding: 4rem 0 3rem; text-align: center; }
        .hero p { margin-left: auto; margin-right: auto; }
        .hero-cta { justify-content: center; }
        .hero-stats { justify-content: center; gap: 1.5rem; }
        .hero-image-wrap { margin-top: 3rem; }
    }

    @media (max-width: 768px) {
        .hero h1 { font-size: 2.2rem; }
        .hero-stats { gap: 1rem; flex-wrap: wrap; }
        .stat-item { flex: 1; min-width: 80px; }
        .hero-float-badge { left: 50%; transform: translateX(-50%); bottom: -20px; white-space: nowrap; }
        .seller-cta { padding: 3rem 1.5rem; text-align: center; }
        .seller-steps { justify-content: center; }
    }
</style>
@endpush

@section('content')

{{-- ── HERO ── --}}
<section class="hero">
    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-eyebrow">
                    <i class="bi bi-stars"></i> Marketplace Preloved #1 Indonesia
                </div>
                <h1>Temukan Barang <em>Preloved</em> yang Kamu Inginkan</h1>
                <p>Beli dan jual barang bekas berkualitas dengan harga terbaik. Aman, mudah, dan terpercaya.</p>
                <div class="hero-cta">
                    <a href="{{ route('products.index') }}" class="btn-hero-primary">
                        <i class="bi bi-search"></i> Cari Produk
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn-hero-ghost">
                            <i class="bi bi-person-plus"></i> Daftar Gratis
                        </a>
                    @endguest
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span>10K+</span>
                        <small>Produk Aktif</small>
                    </div>
                    <div class="stat-item">
                        <span>5K+</span>
                        <small>Penjual Terverifikasi</small>
                    </div>
                    <div class="stat-item">
                        <span>98%</span>
                        <small>Pembeli Puas</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-wrap">
                    <div class="hero-img-card">
                        <img src="https://images.unsplash.com/photo-1512909006721-3d6018887383?w=600&q=80" alt="Preloved products">
                    </div>
                    <div class="hero-float-badge">
                        <i class="bi bi-shield-check"></i>
                        <div>
                            <div style="font-size:0.8rem;font-weight:700;color:var(--navy)">100% Aman</div>
                            <div style="font-size:0.72rem;color:var(--muted);font-weight:400">Transaksi Terlindungi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── CATEGORIES ── --}}
<section class="py-5" style="background:white">
    <div class="container">
        <div class="row align-items-end section-header">
            <div class="col">
                <span class="section-label">Kategori</span>
                <h2 class="section-title">Kategori Populer</h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('products.index') }}" class="btn-navy d-inline-flex align-items-center gap-2" style="padding:0.55rem 1.2rem;border-radius:8px;text-decoration:none;font-size:0.85rem">
                    Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="row g-3">
            @foreach($categories as $category)
            <div class="col-md-4 col-lg-3 col-6">
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="cat-chip">
                    <div class="cat-icon"><i class="bi bi-tag-fill"></i></div>
                    <span class="cat-name">{{ $category->name }}</span>
                    <i class="bi bi-arrow-right cat-arrow"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── PRODUCTS ── --}}
<section class="products-section">
    <div class="container">
        <div class="row align-items-end section-header">
            <div class="col">
                <span class="section-label">Terbaru</span>
                <h2 class="section-title">Produk Terbaru</h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('products.index') }}" class="btn-navy d-inline-flex align-items-center gap-2" style="padding:0.55rem 1.2rem;border-radius:8px;text-decoration:none;font-size:0.85rem">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="row g-3">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card-product">
                    <div class="position-relative">
                        <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <span class="badge-condition">
                            {{ $product->condition == 'baru' ? 'Baru' : ($product->condition == 'seperti_baru' ? 'Seperti Baru' : 'Bekas') }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="card-title">{{ $product->name }}</p>
                        <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="seller-info">
                            <span class="seller-name"><i class="bi bi-person-circle me-1"></i>{{ $product->user->name }}</span>
                            <a href="{{ route('products.show', $product) }}" class="btn-navy" style="font-size:0.78rem;padding:0.35rem 0.85rem;border-radius:6px;text-decoration:none">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── HOW IT WORKS ── --}}
<section class="steps-section">
    <div class="container">
        <div class="text-center section-header">
            <span class="section-label">Panduan</span>
            <h2 class="section-title">Cara Menggunakan Preloved Market</h2>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <div class="step-icon"><i class="bi bi-person-plus"></i></div>
                    <h5>Daftar Akun</h5>
                    <p>Buat akun gratis sebagai pembeli. Ingin menjual? Ajukan jadi seller setelah login.</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="step-card">
                    <div class="step-num">2</div>
                    <div class="step-icon"><i class="bi bi-search"></i></div>
                    <h5>Cari Produk</h5>
                    <p>Jelajahi ribuan produk preloved berkualitas dengan filter pencarian spesifik.</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="step-card">
                    <div class="step-num">3</div>
                    <div class="step-icon"><i class="bi bi-bag-check"></i></div>
                    <h5>Beli / Tawar</h5>
                    <p>Tambah ke keranjang atau hubungi penjual langsung untuk negosiasi harga.</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="step-card">
                    <div class="step-num">4</div>
                    <div class="step-icon"><i class="bi bi-truck"></i></div>
                    <h5>Terima Barang</h5>
                    <p>Lakukan pembayaran, tunggu pengiriman, dan konfirmasi penerimaan barang.</p>
                </div>
            </div>
        </div>

        {{-- Seller CTA --}}
        <div class="seller-cta">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h4>Ingin Menjual Barang Preloved?</h4>
                    <p>Daftarkan toko kamu dan mulai berjualan dalam hitungan menit.</p>
                    <div class="seller-steps">
                        <div class="seller-step-pill"><span class="num">1</span> Ajukan jadi seller</div>
                        <div class="seller-step-pill"><span class="num">2</span> Upload KTP & data toko</div>
                        <div class="seller-step-pill"><span class="num">3</span> Tunggu verifikasi</div>
                        <div class="seller-step-pill"><span class="num">4</span> Mulai upload produk</div>
                    </div>
                </div>
                <div class="col-lg-5 text-lg-end">
                    @auth
                        @if(Auth::user()->role == 'buyer')
                            <a href="{{ route('seller.request') }}" class="btn-hero-primary">
                                <i class="bi bi-shop"></i> Ajukan Jadi Seller
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-hero-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Login untuk Jadi Seller
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

@endsection