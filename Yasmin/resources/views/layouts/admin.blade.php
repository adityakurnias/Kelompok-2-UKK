<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — Preloved</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink: #0d0d0d;
            --navy: #0f2444;
            --navy-mid: #1a3a6b;
            --accent: #e8c547;
            --soft: #f5f3ef;
            --muted: #8a8a8a;
            --border: #e8e4dd;
            --sidebar-w: 240px;
            --topbar-h: 60px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--soft);
            color: var(--ink);
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--navy);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 200;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s;
        }

        .sidebar-brand {
            padding: 1.4rem 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }

        .sidebar-brand .brand-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            line-height: 1;
        }

        .sidebar-brand .brand-text span { color: var(--accent); }

        .sidebar-brand .badge-admin {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: rgba(232,197,71,0.18);
            color: var(--accent);
            border: 1px solid rgba(232,197,71,0.3);
            border-radius: 4px;
            padding: 2px 6px;
            margin-left: auto;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex: 1;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 0.75rem 1.5rem 0.4rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.65rem 1.5rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.2s;
            position: relative;
        }

        .sidebar-link i {
            font-size: 1rem;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-link:hover {
            color: white;
            background: rgba(255,255,255,0.05);
            border-left-color: rgba(255,255,255,0.2);
        }

        .sidebar-link.active {
            color: var(--accent);
            background: rgba(232,197,71,0.1);
            border-left-color: var(--accent);
        }

        .sidebar-link .badge-pill {
            margin-left: auto;
            background: #e53e3e;
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .sidebar-user .avatar {
            width: 34px;
            height: 34px;
            background: rgba(232,197,71,0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .sidebar-user .info .name {
            font-size: 0.82rem;
            font-weight: 600;
            color: white;
            line-height: 1.2;
        }

        .sidebar-user .info .role {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.4);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            background: rgba(229,62,62,0.1);
            color: #fc8181;
            border: 1px solid rgba(229,62,62,0.2);
            border-radius: 8px;
            padding: 0.5rem 0.85rem;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: rgba(229,62,62,0.2);
            color: #feb2b2;
        }

        /* ── TOPBAR ── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--topbar-h);
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 1.75rem;
            gap: 1rem;
            z-index: 100;
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--navy);
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .topbar-time {
            font-size: 0.8rem;
            color: var(--muted);
        }

        .topbar-divider {
            width: 1px;
            height: 22px;
            background: var(--border);
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--navy);
            font-size: 1.2rem;
            padding: 0.3rem;
            cursor: pointer;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            flex: 1;
            padding: 2rem 2rem 3rem;
            min-height: calc(100vh - var(--topbar-h));
        }

        /* ── GLOBAL COMPONENTS ── */
        .page-header {
            margin-bottom: 1.75rem;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.2rem;
        }

        .page-header p {
            font-size: 0.875rem;
            color: var(--muted);
            margin: 0;
        }

        .card-admin {
            background: white;
            border-radius: 14px;
            border: 1.5px solid var(--border);
            overflow: hidden;
        }

        .card-admin .card-header-admin {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--navy);
        }

        .card-admin .card-body-admin {
            padding: 1.5rem;
        }

        .btn-admin {
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.1rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }

        .btn-admin:hover {
            background: var(--navy-mid);
            color: white;
            transform: translateY(-1px);
        }

        .btn-admin-ghost {
            background: transparent;
            color: var(--navy);
            border: 1.5px solid var(--navy);
            border-radius: 8px;
            padding: 0.45rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }

        .btn-admin-ghost:hover {
            background: var(--navy);
            color: white;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 10px;
            font-size: 0.875rem;
        }

        /* Table */
        .table-admin {
            font-size: 0.875rem;
            margin: 0;
        }

        .table-admin thead th {
            background: var(--soft);
            color: var(--navy);
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border: none;
            padding: 0.75rem 1rem;
        }

        .table-admin tbody td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: var(--ink);
        }

        .table-admin tbody tr:last-child td { border-bottom: none; }
        .table-admin tbody tr:hover td { background: var(--soft); }

        /* Badges */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-status.success { background: #f0fff4; color: #276749; }
        .badge-status.warning { background: #fffff0; color: #975a16; }
        .badge-status.danger  { background: #fff5f5; color: #9b2c2c; }
        .badge-status.info    { background: #ebf8ff; color: #2c5282; }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 199;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show { display: block; }

            .topbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar Overlay (mobile) --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- ── SIDEBAR ── --}}
<aside class="sidebar" id="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <div>
            <div class="brand-text">Pre<span>loved</span></div>
        </div>
        <span class="badge-admin">Admin</span>
    </a>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section-label">Manajemen</div>
        <a href="{{ route('admin.users') }}"
           class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Kelola Users
        </a>
        <a href="{{ route('admin.categories') }}"
           class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori
        </a>
        <a href="{{ route('admin.products.moderation') }}"
           class="sidebar-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Moderasi Produk
        </a>

        <div class="nav-section-label">Transaksi & Seller</div>
        <a href="{{ route('admin.orders') }}"
           class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <i class="bi bi-cart-check"></i> Semua Pesanan
        </a>
        <a href="{{ route('admin.seller-requests') }}"
           class="sidebar-link {{ request()->routeIs('admin.seller-requests*') ? 'active' : '' }}">
            <i class="bi bi-shop"></i> Seller Requests
            @php $pending = \App\Models\SellerRequest::where('status','pending')->count(); @endphp
            @if($pending > 0)
                <span class="badge-pill">{{ $pending }}</span>
            @endif
        </a>

        <div class="nav-section-label">Lainnya</div>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> Lihat Toko
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar"><i class="bi bi-person-fill"></i></div>
            <div class="info">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">Administrator</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
</aside>

{{-- ── TOPBAR ── --}}
<header class="topbar">
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>
    <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
    <div class="topbar-right">
        <span class="topbar-time" id="clock"></span>
        <div class="topbar-divider"></div>
        <span style="font-size:0.82rem;color:var(--muted)">
            <i class="bi bi-envelope me-1"></i>{{ Auth::user()->email }}
        </span>
    </div>
</header>

{{-- ── MAIN ── --}}
<main class="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Live clock
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', {
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Sidebar toggle (mobile)
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }
</script>
@stack('scripts')
</body>
</html>