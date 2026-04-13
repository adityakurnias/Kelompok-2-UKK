@extends('layouts.app')

@section('title', 'Dashboard Buyer - Preloved Market')

@push('styles')
<style>
    .dashboard-wrapper {
        padding: 2rem 0 4rem;
        background: var(--soft);
        min-height: 80vh;
    }
    
    /* Welcome Card */
    .welcome-card {
        background: linear-gradient(135deg, var(--navy) 0%, #1a3a5f 100%);
        border-radius: 18px;
        padding: 2rem 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-card::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .welcome-card h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .welcome-card p {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    /* Stat Cards */
    .stat-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
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
    .stat-icon.info { background: rgba(59,130,246,0.1); color: #3b82f6; }
    .stat-icon.success { background: rgba(16,185,129,0.1); color: #10b981; }
    
    .stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1.2;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Cart Summary */
    .cart-summary {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
    }
    
    .cart-summary .cart-icon {
        width: 60px;
        height: 60px;
        background: var(--navy);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
    }
    
    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    
    .section-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--navy);
        margin: 0;
    }
    
    .section-header a {
        color: var(--navy);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .section-header a:hover {
        text-decoration: underline;
    }
    
    /* Recent Orders */
    .recent-order-item {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
    }
    
    .recent-order-item:hover {
        border-color: var(--navy);
        background: #fbfbfb;
        transform: translateX(4px);
    }
    
    .order-number {
        font-family: 'DM Sans', sans-serif;
        font-weight: 700;
        color: var(--navy);
    }
    
    /* Quick Actions */
    .quick-action-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    
    .quick-action {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 1rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .quick-action:hover {
        border-color: var(--navy);
        transform: translateY(-2px);
    }
    
    .quick-action i {
        font-size: 1.5rem;
        color: var(--navy);
        margin-bottom: 0.5rem;
    }
    
    .quick-action span {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--ink);
    }
    
    /* Empty State */
    .empty-state {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 3rem;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 3.5rem;
        color: var(--border);
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        color: var(--muted);
        margin-bottom: 1.5rem;
    }
    
    /* Badge Status */
    .badge {
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <div class="container">
        
        {{-- Welcome Card --}}
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>Halo, {{ $user->name }}! 👋</h2>
                    <p>Selamat datang kembali di dashboard kamu. Yuk, lihat aktivitas belanja terbaru!</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('products.index') }}" class="btn btn-light">
                        <i class="bi bi-shop"></i> Mulai Belanja
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
                    <div class="stat-value">{{ $totalOrders }}</div>
                    <div class="stat-label">Total Pesanan</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-value">{{ $pendingOrders }}</div>
                    <div class="stat-label">Menunggu</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon info">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="stat-value">{{ $shippedOrders }}</div>
                    <div class="stat-label">Dikirim</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $completedOrders }}</div>
                    <div class="stat-label">Selesai</div>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            {{-- Left Column --}}
            <div class="col-lg-8">
                
                {{-- Cart Summary --}}
                <div class="cart-summary mb-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="cart-icon">
                                <i class="bi bi-cart"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="mb-1">Keranjang Belanja</h5>
                            <p class="text-muted mb-0">
                                @if($cartCount > 0)
                                    {{ $cartCount }} item (Rp {{ number_format($cartTotal, 0, ',', '.') }})
                                @else
                                    Keranjang kosong
                                @endif
                            </p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('cart.index') }}" class="btn btn-navy">
                                <i class="bi bi-cart-check"></i> Lihat
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Recent Orders --}}
                <div class="section-header">
                    <h3>Pesanan Terbaru</h3>
                    <a href="{{ route('orders.index') }}">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                
                @if($recentOrders->count() > 0)
                    @foreach($recentOrders as $order)
                    <div class="recent-order-item">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <small class="text-muted">No. Order</small>
                                <div class="order-number">{{ $order->order_number }}</div>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Tanggal</small>
                                <div>{{ $order->created_at->format('d/m/Y') }}</div>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Total</small>
                                <div class="fw-bold text-navy">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Status</small>
                                <div>
                                    @php
                                        $statusClass = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'shipped' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ][$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-navy">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Belum ada pesanan. Yuk, mulai belanja!</p>
                        <a href="{{ route('products.index') }}" class="btn btn-navy">
                            <i class="bi bi-shop"></i> Lihat Produk
                        </a>
                    </div>
                @endif
                
            </div>
            
            {{-- Right Column --}}
            <div class="col-lg-4">
                
                {{-- Quick Actions --}}
                <div class="card mb-4">
                    <div class="card-header bg-navy text-white">
                        <h5 class="mb-0"><i class="bi bi-lightning"></i> Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="quick-action-grid">
                            <a href="{{ route('products.index') }}" class="quick-action">
                                <i class="bi bi-shop"></i>
                                <span>Belanja</span>
                            </a>
                            <a href="{{ route('cart.index') }}" class="quick-action">
                                <i class="bi bi-cart"></i>
                                <span>Keranjang</span>
                            </a>
                            <a href="{{ route('orders.index') }}" class="quick-action">
                                <i class="bi bi-box"></i>
                                <span>Pesanan</span>
                            </a>
                            <a href="{{ route('profile') }}" class="quick-action">
                                <i class="bi bi-person"></i>
                                <span>Profil</span>
                            </a>
                            {{-- Link Jadi Seller --}}
                            <a href="{{ route('seller.request') }}" class="quick-action" style="grid-column: span 2; background: #fff4e5; border-color: #ffb347;">
                                <i class="bi bi-shop" style="color: #ff8c00;"></i>
                                <span style="color: #ff8c00; font-weight: 700;">Jadi Seller</span>
                            </a>
                        </div>
                        
                        <hr>
                        
                        {{-- Link Jadi Seller versi button (alternatif) --}}
                        <a href="{{ route('seller.request') }}" class="btn btn-outline-warning w-100">
                            <i class="bi bi-shop"></i> Ajukan Jadi Seller
                        </a>
                    </div>
                </div>
                
                {{-- Info Member --}}
                <div class="card">
                    <div class="card-header bg-navy text-white">
                        <h5 class="mb-0"><i class="bi bi-person-circle"></i> Info Member</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                @if($user->photo)
                                    <img src="{{ asset('storage/users/' . $user->photo) }}" 
                                         width="50" height="50" class="rounded-circle">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-person-fill text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between text-center">
                            <div>
                                <div class="fw-bold text-navy">{{ $totalOrders }}</div>
                                <small class="text-muted">Pesanan</small>
                            </div>
                            <div>
                                <div class="fw-bold text-navy">{{ $completedOrders }}</div>
                                <small class="text-muted">Selesai</small>
                            </div>
                            <div>
                                <div class="fw-bold text-navy">{{ $cartCount }}</div>
                                <small class="text-muted">Keranjang</small>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <small class="text-muted d-block">
                            <i class="bi bi-calendar"></i> Member sejak {{ $user->created_at->format('d M Y') }}
                        </small>
                    </div>
                </div>
                
            </div>
        </div>
        
        {{-- Recommended Products --}}
        @if($recommendedProducts->count() > 0)
        <div class="mt-5">
            <div class="section-header">
                <h3>Rekomendasi Untukmu</h3>
                <a href="{{ route('products.index') }}">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            
            <div class="row g-3">
                @foreach($recommendedProducts as $product)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="card-product">
                        <div class="position-relative overflow-hidden">
                            @if(Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            <span class="badge-condition">
                                {{ $product->condition == 'baru' ? 'Baru' : ($product->condition == 'seperti_baru' ? 'Spt Baru' : 'Bekas') }}
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="card-title">{{ Str::limit($product->name, 40) }}</p>
                            <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="seller-info mb-2 text-muted small">
                                <span class="seller-name text-truncate">
                                    <i class="bi bi-person-circle"></i> {{ $product->user->name }}
                                </span>
                            </div>
                            <div class="d-flex gap-2">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn-navy btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="bi bi-cart-plus"></i> +Keranjang
                                    </button>
                                </form>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-navy btn-sm" style="font-size: 0.75rem;">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
    </div>
</div>
@endsection