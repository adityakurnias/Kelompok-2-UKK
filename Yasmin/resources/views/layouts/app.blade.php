<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Preloved Marketplace')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --ink: #0d0d0d;
            --navy: #0f2444;
            --navy-mid: #1a3a6b;
            --accent: #e8c547;
            --soft: #f5f3ef;
            --muted: #8a8a8a;
            --border: #e8e4dd;
            --white: #ffffff;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--soft);
            color: var(--ink);
            margin: 0;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: var(--navy) !important;
            padding: 0;
            border-bottom: 3.5px solid var(--accent);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            width: 100%;
            padding: 0.85rem 0;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.45rem;
            color: var(--white) !important;
            letter-spacing: -0.6px;
            white-space: nowrap;
            text-decoration: none;
        }

        .navbar-brand span { color: var(--accent); }

        .search-wrap {
            flex: 1;
            max-width: 520px;
            margin: 0 auto;
        }

        .search-wrap .input-group {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.2s;
        }

        .search-wrap .input-group:focus-within {
            background: rgba(255,255,255,0.12);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(232,197,71,0.15);
        }

        .search-wrap .form-control {
            background: transparent;
            border: none;
            color: white;
            font-size: 0.88rem;
            padding: 0.65rem 1rem;
        }

        .search-wrap .form-control::placeholder { color: rgba(255,255,255,0.4); }
        .search-wrap .form-control:focus { box-shadow: none; color: white; }

        .search-wrap .btn {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.6);
            padding: 0.6rem 1rem;
            transition: all 0.2s;
        }
        .search-wrap .btn:hover { color: var(--accent); }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: auto;
        }

        .nav-link-item {
            color: rgba(255,255,255,0.85) !important;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.55rem 0.85rem !important;
            border-radius: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
        }

        .nav-link-item:hover {
            background: rgba(255,255,255,0.08);
            color: white !important;
        }

        .btn-nav-accent {
            background: var(--accent);
            color: var(--navy) !important;
            font-weight: 700;
            border-radius: 8px;
            padding: 0.55rem 1.25rem !important;
            font-size: 0.88rem;
            box-shadow: 0 4px 10px rgba(232,197,71,0.2);
        }

        .btn-nav-accent:hover {
            background: #f5d45a;
            color: var(--navy) !important;
            transform: translateY(-1.5px);
        }

        /* ── MOBILE NAV BAR ── */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            display: none;
            justify-content: space-around;
            padding: 0.65rem 0;
            box-shadow: 0 -4px 16px rgba(0,0,0,0.08);
            z-index: 1030;
            border-top: 1px solid var(--border);
            border-radius: 18px 18px 0 0;
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--muted);
            font-size: 0.68rem;
            font-weight: 600;
            gap: 0.2rem;
            transition: color 0.2s;
            flex: 1;
        }

        .mobile-nav-item i { font-size: 1.25rem; }
        .mobile-nav-item.active { color: var(--navy); }
        .mobile-nav-item.active i { color: var(--navy); }

        .cart-badge { position: relative; }
        .cart-badge .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #e53e3e;
            font-size: 0.65rem;
            padding: 2px 6px;
            border: 2px solid white;
            font-weight: 800;
        }

        /* ── OFFCANVAS ── */
        .offcanvas {
            border-radius: 20px 0 0 20px;
            border-left: none;
        }
        .offcanvas-header { border-bottom: 1px solid var(--border); padding: 1.5rem; }
        .offcanvas-title { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--navy); }
        .offcanvas-body { padding: 1.5rem; }

        .offcanvas-menu-item {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            color: var(--ink);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
            transition: background 0.2s;
        }
        .offcanvas-menu-item:hover { background: var(--soft); color: var(--navy); }
        .offcanvas-menu-item i { font-size: 1.2rem; color: var(--muted); }
        .offcanvas-menu-item.logout { color: #e53e3e; }
        .offcanvas-menu-item.logout i { color: #e53e3e; }

        /* ── FOOTER ── */
        footer {
            background: var(--navy);
            color: rgba(255,255,255,0.7);
            padding: 4.5rem 0 2rem;
            margin-top: 6rem;
        }

        footer .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: white;
            font-weight: 700;
            margin-bottom: 1rem;
            display: block;
        }
        footer .brand span { color: var(--accent); }

        /* ── MEDIA QUERIES ── */
        @media (max-width: 991px) {
            .navbar-inner { gap: 1rem; }
            .navbar-brand { font-size: 1.25rem; }
        }

        @media (max-width: 768px) {
            body { padding-bottom: 75px; } /* Space for bottom nav */
            .mobile-bottom-nav { display: flex; }
            .nav-actions .nav-link-item:not(.btn-nav-accent) { display: none; }
            .search-wrap { display: none; }
            .page-header h1 { font-size: 1.5rem; }
            .btn-outline-navy, .btn-navy { padding: 0.5rem 1rem; font-size: 0.85rem; }
            footer { padding: 3rem 0 6rem; text-align: center; }
            .footer-socials { justify-content: center; margin-bottom: 2rem; }
        }

        /* X-Small screens */
        @media (max-width: 480px) {
            .navbar-brand { font-size: 1.15rem; }
            .mobile-nav-item span { font-size: 0.62rem; }
            .mobile-nav-item i { font-size: 1.15rem; }
        }

        /* Page header */
        .page-header {
            margin-bottom: 2rem;
            border-bottom: 2px solid var(--border);
            padding-bottom: 1rem;
        }
        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.25rem;
        }
        .page-header p {
            color: var(--muted);
            font-size: 0.95rem;
            margin: 0;
        }

        /* ── GLOBAL COMPONENTS ── */
        .btn-navy {
            background: var(--navy);
            color: white !important;
            border-radius: 8px;
            padding: 0.6rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-navy:hover {
            background: var(--navy-mid);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15,36,68,0.15);
        }

        .btn-outline-navy {
            border: 1.5px solid var(--navy) !important;
            color: var(--navy) !important;
            background: transparent !important;
            border-radius: 8px;
            padding: 0.6rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-outline-navy:hover {
            background: var(--navy) !important;
            color: white !important;
            transform: translateY(-1px);
        }

        /* ── PRODUCT CARD ── */
        .card-product {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .card-product:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(15,36,68,0.12);
            border-color: var(--navy);
        }

        .card-product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        @media (max-width: 768px) {
            .card-product img { height: 160px; }
        }

        .card-product:hover img {
            transform: scale(1.08);
        }

        .card-product .card-body {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-product .card-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.8em;
        }

        .card-product .price {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.75rem;
        }

        .badge-condition {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            color: var(--navy);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 2;
            border: 1px solid rgba(15,36,68,0.1);
        }

        .seller-info {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .seller-name {
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <div class="navbar-inner">
            <a class="navbar-brand" href="{{ route('home') }}">
                Pre<span>loved</span>
            </a>

            <div class="search-wrap d-none d-md-block">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                        <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="nav-actions">
                @auth
                    @php 
                        $cartCount = App\Models\Cart::where('user_id', Auth::id())->count(); 
                    @endphp
                    <a href="{{ route('cart.index') }}" class="nav-link-item cart-badge d-none d-lg-flex">
                        <i class="bi bi-bag"></i>
                        @if($cartCount > 0)
                            <span class="badge rounded-pill">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <a class="nav-link-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#userMenu">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                        <i class="bi bi-chevron-down d-none d-lg-inline" style="font-size:0.65rem"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link-item">Masuk</a>
                    <a href="{{ route('register') }}" class="nav-link-item btn-nav-accent">Daftar</a>
                @endauth
            </div>

        {{-- Mobile search --}}
        <div class="w-100 pb-2 d-md-none">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button class="btn" type="submit" style="background:var(--accent);color:var(--navy)"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</nav>

<main>
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @yield('content')
</main>

<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <span class="brand">Pre<span>loved</span></span>
                <p>Tempat terbaik untuk membeli dan menjual barang preloved berkualitas. Bergabunglah dengan ribuan penjual dan pembeli!</p>
                <div class="footer-socials mt-3">
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h6>Jelajahi</h6>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}">Semua Produk</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6>Bantuan</h6>
                <ul>
                    <li><a href="#">Cara Berbelanja</a></li>
                    <li><a href="#">Cara Berjualan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6>Kontak</h6>
                <ul>
                    <li style="font-size:0.875rem;margin-bottom:0.5rem"><i class="bi bi-whatsapp me-2" style="color:var(--accent)"></i>+62 812-3456-7890</li>
                    <li style="font-size:0.875rem;margin-bottom:0.5rem"><i class="bi bi-envelope me-2" style="color:var(--accent)"></i>info@preloved.id</li>
                    <li style="font-size:0.875rem"><i class="bi bi-geo-alt me-2" style="color:var(--accent)"></i>Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>
        <hr class="divider">
        <p class="copyright text-center mb-0">&copy; {{ date('Y') }} Preloved Market. All rights reserved.</p>
    </div>
</footer>

{{-- ── OFFCANVAS MENU ── --}}
@auth
<div class="offcanvas offcanvas-end" tabindex="-1" id="userMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu Utama</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
            <div class="bg-navy p-3 rounded-circle text-white d-flex align-items-center justify-center" style="width:50px;height:50px">
                <i class="bi bi-person" style="font-size:1.5rem"></i>
            </div>
            <div>
                <div class="fw-bold fs-5">{{ Auth::user()->name }}</div>
                <div class="text-muted small text-capitalize">{{ Auth::user()->role }}</div>
            </div>
        </div>

        <a class="offcanvas-menu-item" href="{{ route('home') }}">
            <i class="bi bi-house"></i> Beranda
        </a>
        
        @if(Auth::user()->role == 'buyer')
            <a class="offcanvas-menu-item" href="{{ route('buyer.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard Buyer
            </a>
            <a class="offcanvas-menu-item" href="{{ route('orders.index') }}">
                <i class="bi bi-box"></i> Pesanan Saya
            </a>
            <a class="offcanvas-menu-item" href="{{ route('cart.index') }}">
                <i class="bi bi-cart"></i> Keranjang Belanja
            </a>
            <hr class="my-3">
            <a class="offcanvas-menu-item" href="{{ route('seller.request') }}">
                <i class="bi bi-shop"></i> Jadi Seller
            </a>
        @endif

        @if(Auth::user()->role == 'seller')
            <a class="offcanvas-menu-item" href="{{ route('seller.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard Seller
            </a>
            <a class="offcanvas-menu-item" href="{{ route('seller.products') }}">
                <i class="bi bi-box-seam"></i> Produk Saya
            </a>
            <a class="offcanvas-menu-item" href="{{ route('seller.orders') }}">
                <i class="bi bi-cart-check"></i> Pesanan Masuk
            </a>
        @endif

        @if(Auth::user()->role == 'admin')
            <a class="offcanvas-menu-item" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-shield-check"></i> Admin Panel
            </a>
        @endif

        <hr class="my-3">
        <a class="offcanvas-menu-item" href="{{ route('profile') }}">
            <i class="bi bi-person-gear"></i> Pengaturan Profil
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="offcanvas-menu-item logout border-0 w-100 bg-transparent text-start">
                <i class="bi bi-box-arrow-right"></i> Keluar Sesi
            </button>
        </form>
    </div>
</div>
@endauth

{{-- ── MOBILE BOTTOM NAV ── --}}
<div class="mobile-bottom-nav">
    <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="bi bi-house-door{{ request()->routeIs('home') ? '-fill' : '' }}"></i>
        <span>Beranda</span>
    </a>
    <a href="{{ route('products.index') }}" class="mobile-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="bi bi-grid{{ request()->routeIs('products.*') ? '-fill' : '' }}"></i>
        <span>Explore</span>
    </a>
    @auth
        @php $cartCount = App\Models\Cart::where('user_id', Auth::id())->count(); @endphp
        <a href="{{ route('cart.index') }}" class="mobile-nav-item cart-badge {{ request()->routeIs('cart.*') ? 'active' : '' }}">
            <i class="bi bi-bag{{ request()->routeIs('cart.*') ? '-fill' : '' }}"></i>
            @if($cartCount > 0)
                <span class="badge rounded-pill">{{ $cartCount }}</span>
            @endif
            <span>Keranjang</span>
        </a>
        <a href="#" class="mobile-nav-item" data-bs-toggle="offcanvas" data-bs-target="#userMenu">
            <i class="bi bi-person-circle"></i>
            <span>Akun</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="mobile-nav-item">
            <i class="bi bi-person"></i>
            <span>Masuk</span>
        </a>
    @endauth
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stack('scripts')
</body>
</html>