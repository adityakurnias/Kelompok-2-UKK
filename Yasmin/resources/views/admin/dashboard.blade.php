@extends('layouts.admin')

@section('title', 'Dashboard Admin — Preloved Market')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* ── STAT CARDS ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1199px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px)  { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: white;
        border-radius: 14px;
        border: 1.5px solid var(--border);
        padding: 1.4rem 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(15,36,68,0.09);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .stat-icon.blue   { background: #ebf4ff; color: #2b6cb0; }
    .stat-icon.green  { background: #f0fff4; color: #276749; }
    .stat-icon.yellow { background: #fffff0; color: #975a16; }
    .stat-icon.purple { background: #faf5ff; color: #6b46c1; }

    .stat-body { flex: 1; min-width: 0; }

    .stat-label {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.3rem;
    }

    .stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1;
        margin-bottom: 0.4rem;
    }

    .stat-meta {
        font-size: 0.78rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .stat-meta.up   { color: #276749; }
    .stat-meta.warn { color: #975a16; }

    /* ── QUICK ACTIONS ── */
    .quick-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 991px) { .quick-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px)  { .quick-grid { grid-template-columns: 1fr; } }

    .quick-card {
        background: white;
        border-radius: 14px;
        border: 1.5px solid var(--border);
        padding: 1.4rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        color: var(--ink);
        transition: all 0.22s;
    }

    .quick-card:hover {
        border-color: var(--navy);
        background: var(--navy);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 32px rgba(15,36,68,0.15);
    }

    .quick-card:hover .quick-icon { background: rgba(255,255,255,0.12); color: var(--accent); }
    .quick-card:hover .quick-label { color: white; }
    .quick-card:hover .quick-desc { color: rgba(255,255,255,0.6); }
    .quick-card:hover .quick-arrow { opacity: 1; color: var(--accent); }

    .quick-icon {
        width: 46px;
        height: 46px;
        background: var(--soft);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--navy);
        flex-shrink: 0;
        transition: all 0.22s;
    }

    .quick-text { flex: 1; min-width: 0; }

    .quick-label {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--navy);
        transition: color 0.22s;
    }

    .quick-desc {
        font-size: 0.78rem;
        color: var(--muted);
        margin-top: 0.15rem;
        transition: color 0.22s;
    }

    .quick-arrow {
        font-size: 0.9rem;
        color: var(--muted);
        opacity: 0.4;
        transition: all 0.22s;
    }

    /* ── BOTTOM GRID ── */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 1rem;
    }

    @media (max-width: 991px) { .bottom-grid { grid-template-columns: 1fr; } }

    /* Recent table card */
    .info-card {
        background: white;
        border-radius: 14px;
        border: 1.5px solid var(--border);
        overflow: hidden;
    }

    .info-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .info-card-header h6 {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--navy);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card-header a {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--navy);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .info-card-header a:hover { text-decoration: underline; }

    /* Activity feed */
    .activity-list { padding: 0.5rem 0; }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        padding: 0.75rem 1.5rem;
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .activity-item:last-child { border-bottom: none; }
    .activity-item:hover { background: var(--soft); }

    .activity-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-top: 0.35rem;
        flex-shrink: 0;
    }

    .activity-dot.green  { background: #48bb78; }
    .activity-dot.blue   { background: #4299e1; }
    .activity-dot.yellow { background: #ecc94b; }
    .activity-dot.red    { background: #e53e3e; }

    .activity-text {
        flex: 1;
        font-size: 0.82rem;
        color: var(--ink);
        line-height: 1.5;
    }

    .activity-time {
        font-size: 0.75rem;
        color: var(--muted);
        white-space: nowrap;
        margin-top: 0.1rem;
    }

    /* Admin info banner */
    .admin-banner {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
        border-radius: 14px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .admin-banner i {
        font-size: 2rem;
        color: var(--accent);
        flex-shrink: 0;
    }

    .admin-banner .text h6 {
        color: white;
        font-weight: 700;
        margin-bottom: 0.2rem;
        font-size: 0.9rem;
    }

    .admin-banner .text p {
        color: rgba(255,255,255,0.55);
        font-size: 0.8rem;
        margin: 0;
    }

    /* Seller request notice */
    .request-notice {
        border-radius: 12px;
        overflow: hidden;
    }

    .request-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .request-item:last-child { border-bottom: none; }

    .request-avatar {
        width: 34px;
        height: 34px;
        background: var(--soft);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        color: var(--navy);
        flex-shrink: 0;
    }

    .request-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--ink);
    }

    .request-date {
        font-size: 0.75rem;
        color: var(--muted);
    }

    @media (max-width: 768px) {
        .page-header h1 { font-size: 1.4rem; }
        .stat-value { font-size: 1.75rem; }
        .admin-banner { padding: 1.25rem; flex-direction: column; text-align: center; }
        .admin-banner i { font-size: 1.5rem; margin-bottom: 0.5rem; }
        .info-card-header { padding: 0.75rem 1rem; }
        .info-card-header h6 { font-size: 0.75rem; }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>. Berikut ringkasan hari ini.</p>
</div>

{{-- ── STAT CARDS ── --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
        <div class="stat-body">
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ \App\Models\User::count() }}</div>
            @php
                $sellerCount = \App\Models\User::where('role','seller')->count();
                $buyerCount  = \App\Models\User::where('role','buyer')->count();
            @endphp
            <div class="stat-meta"><i class="bi bi-shop me-1"></i>{{ $sellerCount }} seller &nbsp;·&nbsp; <i class="bi bi-person me-1"></i>{{ $buyerCount }} buyer</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-box-seam-fill"></i></div>
        <div class="stat-body">
            <div class="stat-label">Total Produk</div>
            <div class="stat-value">{{ \App\Models\Product::count() }}</div>
            @php $pendingProducts = \App\Models\Product::where('status','pending')->count(); @endphp
            <div class="stat-meta {{ $pendingProducts > 0 ? 'warn' : 'up' }}">
                @if($pendingProducts > 0)
                    <i class="bi bi-exclamation-circle"></i> {{ $pendingProducts }} menunggu moderasi
                @else
                    <i class="bi bi-check-circle"></i> Semua termoderasi
                @endif
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon yellow"><i class="bi bi-shop-window"></i></div>
        <div class="stat-body">
            <div class="stat-label">Seller Requests</div>
            @php $pendingCount = \App\Models\SellerRequest::where('status','pending')->count(); @endphp
            <div class="stat-value">{{ $pendingCount }}</div>
            <div class="stat-meta {{ $pendingCount > 0 ? 'warn' : '' }}">
                @if($pendingCount > 0)
                    <i class="bi bi-exclamation-circle"></i> Menunggu review
                @else
                    <i class="bi bi-check-circle"></i> Semua selesai
                @endif
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple"><i class="bi bi-cart-fill"></i></div>
        <div class="stat-body">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ \App\Models\Order::count() }}</div>
            @php $orderToday = \App\Models\Order::whereDate('created_at', today())->count(); @endphp
            <div class="stat-meta up"><i class="bi bi-calendar-day"></i> {{ $orderToday }} hari ini</div>
        </div>
    </div>
</div>

{{-- ── QUICK ACTIONS ── --}}
<div style="margin-bottom:0.75rem">
    <span style="font-size:0.72rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted)">Aksi Cepat</span>
</div>
<div class="quick-grid">
    <a href="{{ route('admin.users') }}" class="quick-card">
        <div class="quick-icon"><i class="bi bi-people"></i></div>
        <div class="quick-text">
            <div class="quick-label">Kelola Users</div>
            <div class="quick-desc">Lihat, blokir & hapus pengguna</div>
        </div>
        <i class="bi bi-arrow-right quick-arrow"></i>
    </a>

    <a href="{{ route('admin.categories') }}" class="quick-card">
        <div class="quick-icon"><i class="bi bi-tags"></i></div>
        <div class="quick-text">
            <div class="quick-label">Kelola Kategori</div>
            <div class="quick-desc">Tambah, edit & hapus kategori</div>
        </div>
        <i class="bi bi-arrow-right quick-arrow"></i>
    </a>

    <a href="{{ route('admin.products.moderation') }}" class="quick-card">
        <div class="quick-icon"><i class="bi bi-box-seam"></i></div>
        <div class="quick-text">
            <div class="quick-label">Moderasi Produk</div>
            <div class="quick-desc">Approve / reject produk seller</div>
        </div>
        @if($pendingProducts > 0)
            <span style="background:#e53e3e;color:white;font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:20px;flex-shrink:0">{{ $pendingProducts }}</span>
        @else
            <i class="bi bi-arrow-right quick-arrow"></i>
        @endif
    </a>

    <a href="{{ route('admin.seller-requests') }}" class="quick-card">
        <div class="quick-icon"><i class="bi bi-shop"></i></div>
        <div class="quick-text">
            <div class="quick-label">Seller Requests</div>
            <div class="quick-desc">Approve / reject permohonan seller</div>
        </div>
        @if($pendingCount > 0)
            <span style="background:#e53e3e;color:white;font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:20px;flex-shrink:0">{{ $pendingCount }}</span>
        @else
            <i class="bi bi-arrow-right quick-arrow"></i>
        @endif
    </a>
</div>

{{-- ── BOTTOM ── --}}
<div class="bottom-grid">

    {{-- Produk Pending Moderasi --}}
    <div class="info-card">
        <div class="info-card-header">
            <h6><i class="bi bi-clock-history"></i> Produk Menunggu Moderasi</h6>
            <a href="{{ route('admin.products.moderation', ['status' => 'pending']) }}">Lihat semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div>
            @php $pendingProds = \App\Models\Product::with('user')->where('status','pending')->latest()->take(5)->get(); @endphp
            @forelse($pendingProds as $prod)
            <div class="activity-item">
                <div class="activity-dot yellow"></div>
                <div class="activity-text">
                    <strong>{{ $prod->name }}</strong>
                    <br><span style="color:var(--muted)">oleh {{ $prod->user->name ?? '-' }} · Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                </div>
                <div class="activity-time">{{ $prod->created_at->diffForHumans() }}</div>
            </div>
            @empty
            <div style="padding:2rem 1.5rem;text-align:center">
                <i class="bi bi-check-circle" style="font-size:2rem;color:#48bb78"></i>
                <p style="font-size:0.85rem;color:var(--muted);margin-top:0.5rem">Tidak ada produk pending</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Right Column --}}
    <div style="display:flex;flex-direction:column;gap:1rem">

        {{-- Admin Info --}}
        <div class="admin-banner">
            <i class="bi bi-shield-check"></i>
            <div class="text">
                <h6>Mode Administrator</h6>
                <p>{{ Auth::user()->email }}</p>
            </div>
        </div>

        {{-- Pending Seller Requests --}}
        <div class="info-card">
            <div class="info-card-header">
                <h6><i class="bi bi-hourglass-split"></i> Seller Requests Pending</h6>
                <a href="{{ route('admin.seller-requests') }}">Kelola <i class="bi bi-arrow-right"></i></a>
            </div>
            @php $sellerReqs = \App\Models\SellerRequest::with('user')->where('status','pending')->latest()->take(4)->get(); @endphp
            @forelse($sellerReqs as $req)
            <div class="request-item">
                <div class="request-avatar"><i class="bi bi-person"></i></div>
                <div style="flex:1;min-width:0">
                    <div class="request-name text-truncate">{{ $req->user->name ?? '-' }}</div>
                    <div class="request-date">{{ $req->created_at->diffForHumans() }}</div>
                </div>
                <span style="background:#fffff0;color:#975a16;font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:20px;border:1px solid #fefcbf;white-space:nowrap">Pending</span>
            </div>
            @empty
            <div style="padding:1.5rem;text-align:center">
                <i class="bi bi-check-circle" style="font-size:1.5rem;color:#48bb78"></i>
                <p style="font-size:0.82rem;color:var(--muted);margin-top:0.4rem">Tidak ada request pending</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection