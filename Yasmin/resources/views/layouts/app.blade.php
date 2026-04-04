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
            border-bottom: 3px solid var(--accent);
            box-shadow: none;
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
            font-size: 1.35rem;
            color: var(--white) !important;
            letter-spacing: -0.5px;
            white-space: nowrap;
            text-decoration: none;
        }

        .navbar-brand span {
            color: var(--accent);
        }

        .search-wrap {
            flex: 1;
            max-width: 480px;
            margin: 0 auto;
        }

        .search-wrap .input-group {
            border-radius: 8px;
            overflow: hidden;
        }

        .search-wrap .form-control {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-right: none;
            color: white;
            font-size: 0.875rem;
            padding: 0.6rem 1rem;
        }

        .search-wrap .form-control::placeholder { color: rgba(255,255,255,0.5); }
        .search-wrap .form-control:focus {
            background: rgba(255,255,255,0.15);
            border-color: var(--accent);
            box-shadow: none;
            color: white;
        }

        .search-wrap .btn {
            background: var(--accent);
            border: none;
            color: var(--navy);
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-left: auto;
        }

        .nav-link-item {
            color: rgba(255,255,255,0.8) !important;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.5rem 0.75rem !important;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            text-decoration: none;
        }

        .nav-link-item:hover {
            background: rgba(255,255,255,0.1);
            color: white !important;
        }

        .nav-link-item.active { color: var(--accent) !important; }

        .btn-nav-accent {
            background: var(--accent);
            color: var(--navy) !important;
            font-weight: 600;
            border-radius: 6px;
            padding: 0.45rem 1rem !important;
            font-size: 0.85rem;
        }

        .btn-nav-accent:hover {
            background: #d4b03a;
            color: var(--navy) !important;
        }

        .cart-badge {
            position: relative;
        }

        .cart-badge .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #e53e3e;
            font-size: 0.6rem;
            padding: 2px 5px;
        }

        /* Dropdown */
        .dropdown-menu {
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            padding: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item {
            border-radius: 6px;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--ink);
        }

        .dropdown-item:hover { background: var(--soft); }
        .dropdown-item.text-danger:hover { background: #fff5f5; }

        /* ── FOOTER ── */
        footer {
            background: var(--navy);
            color: rgba(255,255,255,0.7);
            padding: 3.5rem 0 1.5rem;
            margin-top: 5rem;
        }

        footer .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: white;
            font-weight: 700;
            margin-bottom: 0.75rem;
            display: block;
        }

        footer .brand span { color: var(--accent); }

        footer p { font-size: 0.875rem; line-height: 1.7; }

        footer h6 {
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        footer ul { list-style: none; padding: 0; margin: 0; }

        footer ul li { margin-bottom: 0.5rem; }

        footer ul li a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s;
        }

        footer ul li a:hover { color: var(--accent); }

        .footer-socials a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7);
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s;
            margin-right: 0.4rem;
        }

        .footer-socials a:hover {
            background: var(--accent);
            color: var(--navy);
        }

        footer .divider {
            border-color: rgba(255,255,255,0.1);
            margin: 2rem 0 1rem;
        }

        footer .copyright {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.4);
        }

        /* ── GLOBAL CARD ── */
        .card-product {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: transform 0.25s, box-shadow 0.25s;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-product:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(15,36,68,0.12);
        }

        .card-product img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .card-product .card-body { 
            padding: 1rem 1.1rem 1.1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-product .card-title {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 0.3rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .card-product .price {
            color: var(--navy);
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 0.5rem;
        }

        .badge-condition {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(15,36,68,0.85);
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            backdrop-filter: blur(4px);
        }

        .btn-navy {
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.45rem 1rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
        }

        .btn-navy:hover {
            background: var(--navy-mid);
            color: white;
            transform: translateY(-1px);
        }

        .btn-outline-navy {
            background: transparent;
            color: var(--navy);
            border: 1.5px solid var(--navy);
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.45rem 1rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
        }

        .btn-outline-navy:hover {
            background: var(--navy);
            color: white;
        }

        /* Toasts / alerts */
        .alert {
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
        }
        .alert-success {
            background: #f0fff4;
            border: 1.5px solid #c6f6d5;
            color: #276749;
        }
        .alert-danger {
            background: #fff5f5;
            border: 1.5px solid #fed7d7;
            color: #c53030;
        }

        @media (max-width: 768px) {
            .search-wrap { max-width: 100%; }
            .navbar-inner { flex-wrap: wrap; gap: 0.75rem; }
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
                    @if(Auth::user()->role == 'buyer')
                        @php 
                            $cartCount = App\Models\Cart::where('user_id', Auth::id())->count(); 
                        @endphp
                        <a href="{{ route('cart.index') }}" class="nav-link-item cart-badge">
                            <i class="bi bi-bag"></i>
                            @if($cartCount > 0)
                                <span class="badge rounded-pill">{{ $cartCount }}</span>
                            @endif
                        </a>
                    @endif

                    <div class="dropdown">
                        <a class="nav-link-item" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                            <i class="bi bi-chevron-down" style="font-size:0.65rem"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            {{-- Dashboard berdasarkan role --}}
                            @if(Auth::user()->role == 'buyer')
                                <li><a class="dropdown-item" href="{{ route('buyer.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a></li>
                            @endif
                            @if(Auth::user()->role == 'seller')
                                <li><a class="dropdown-item" href="{{ route('seller.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a></li>
                            @endif
                            @if(Auth::user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-shield-check"></i> Admin Panel
                                </a></li>
                            @endif

                            <li><hr class="dropdown-divider mx-2"></li>
                            
                            {{-- Menu Profil --}}
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="bi bi-person"></i> Profil Saya
                            </a></li>
                            
                            {{-- Menu Buyer --}}
                            @if(Auth::user()->role == 'buyer')
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="bi bi-box"></i> Pesanan Saya
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('cart.index') }}">
                                    <i class="bi bi-cart"></i> Keranjang
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('seller.request') }}">
                                    <i class="bi bi-shop"></i> Jadi Seller
                                </a></li>
                            @endif
                            
                            {{-- Menu Seller --}}
                            @if(Auth::user()->role == 'seller')
                                <li><a class="dropdown-item" href="{{ route('seller.products') }}">
                                    <i class="bi bi-box-seam"></i> Produk Saya
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('seller.orders') }}">
                                    <i class="bi bi-cart-check"></i> Pesanan Masuk
                                </a></li>
                            @endif
                            
                            <li><hr class="dropdown-divider mx-2"></li>
                            
                            {{-- Logout --}}
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link-item">Masuk</a>
                    <a href="{{ route('register') }}" class="nav-link-item btn-nav-accent">Daftar</a>
                @endauth
            </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stack('scripts')
</body>
</html>