@extends('layouts.app')

@section('title', 'Dashboard Seller - Preloved Market')

@push('styles')
<style>
    .seller-dashboard {
        padding: 2rem 0 4rem;
        background: var(--soft);
        min-height: 80vh;
    }
    
    .welcome-card {
        background: linear-gradient(135deg, var(--navy) 0%, #1a3a5f 100%);
        border-radius: 18px;
        padding: 2rem 2.5rem;
        color: white;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(15,36,68,0.1);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .stat-icon.primary { background: rgba(15,36,68,0.1); color: var(--navy); }
    .stat-icon.warning { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .stat-icon.success { background: rgba(16,185,129,0.1); color: #10b981; }
    .stat-icon.info { background: rgba(59,130,246,0.1); color: #3b82f6; }
    
    .stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1.2;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 2rem 0 1.25rem;
    }
    
    .section-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--navy);
        margin: 0;
    }
    
    .order-item {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
    }
    
    .order-item:hover {
        border-color: var(--navy);
    }
    
    .quick-action-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    
    .quick-action {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 1.25rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .quick-action:hover {
        border-color: var(--navy);
        transform: translateY(-2px);
    }
    
    .quick-action i {
        font-size: 2rem;
        color: var(--navy);
        margin-bottom: 0.5rem;
    }
    
    .quick-action span {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--ink);
    }

    @media (max-width: 768px) {
        .welcome-card { padding: 1.5rem; text-align: center; }
        .welcome-card h2 { font-size: 1.5rem; }
        .welcome-card .btn { margin-top: 1rem; width: 100%; }
        .stat-value { font-size: 1.5rem; }
        .stat-card { padding: 1rem; }
        .order-item row { flex-wrap: wrap; }
        .order-item [class^="col-"] { margin-bottom: 0.5rem; }
    }

    @media (max-width: 576px) {
        .stat-card { margin-bottom: 1rem; }
        .quick-action-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="seller-dashboard">
    <div class="container">
        
        {{-- Welcome Card --}}
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p>Selamat datang di dashboard seller. Kelola produk dan pesananmu di sini.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('seller.products.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-lg"></i> Upload Produk Baru
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="stat-label">Total Produk</div>
                    <small class="text-muted">{{ $activeProducts }} aktif · {{ $soldProducts }} terjual</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-value">{{ $pendingOrders }}</div>
                    <div class="stat-label">Pending</div>
                    <small class="text-muted">Menunggu konfirmasi</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon info">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="stat-value">{{ $shippedOrders }}</div>
                    <div class="stat-label">Dikirim</div>
                    <small class="text-muted">Dalam perjalanan</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $completedOrders }}</div>
                    <div class="stat-label">Selesai</div>
                    <small class="text-muted">Pesanan selesai</small>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            {{-- Left Column: Quick Actions --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-navy text-white">
                        <h5 class="mb-0"><i class="bi bi-lightning"></i> Menu Seller</h5>
                    </div>
                    <div class="card-body">
                        <div class="quick-action-grid">
                            <a href="{{ route('seller.products') }}" class="quick-action">
                                <i class="bi bi-box-seam"></i>
                                <span>Produk Saya</span>
                            </a>
                            <a href="{{ route('seller.products.create') }}" class="quick-action">
                                <i class="bi bi-plus-circle"></i>
                                <span>Tambah Produk</span>
                            </a>
                            <a href="{{ route('seller.orders') }}" class="quick-action">
                                <i class="bi bi-cart-check"></i>
                                <span>Pesanan Masuk</span>
                            </a>
                            <a href="{{ route('profile') }}" class="quick-action">
                                <i class="bi bi-person"></i>
                                <span>Profil Toko</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Right Column: Recent Orders --}}
            <div class="col-lg-8">
                <div class="section-header">
                    <h3>Pesanan Terbaru</h3>
                    <a href="{{ route('seller.orders') }}">Lihat Semua <i class="bi bi-arrow-right"></i></a>
                </div>
                
                @forelse($recentOrders as $item)
                <div class="order-item">
                    <div class="row align-items-center">
                        <div class="col-6 col-md-3">
                            <small class="text-muted d-block">No. Order</small>
                            <div class="fw-bold small">{{ $item->order->order_number }}</div>
                        </div>
                        <div class="col-6 col-md-2">
                            <small class="text-muted d-block">Produk</small>
                            <div class="small">{{ Str::limit($item->product->name, 12) }}</div>
                        </div>
                        <div class="col-6 col-md-2 mt-2 mt-md-0">
                            <small class="text-muted d-block">Total</small>
                            <div class="fw-bold text-navy small">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-6 col-md-2 mt-2 mt-md-0">
                            <small class="text-muted d-block">Status</small>
                            <div>
                                @php
                                    $statusClass = [
                                        'pending' => 'warning',
                                        'confirmed' => 'info',
                                        'shipped' => 'primary',
                                        'completed' => 'success',
                                        'cancelled' => 'danger'
                                    ][$item->order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}" style="font-size: 0.65rem;">{{ ucfirst($item->order->status) }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('seller.orders') }}" class="btn btn-sm btn-outline-navy w-100 w-md-auto">Detail</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="mt-2">Belum ada pesanan masuk</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection