@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Admin')
@section('page-title', 'Detail Pesanan')

@push('styles')
<style>
    /* ── BREADCRUMB ── */
    .breadcrumb {
        background: none;
        padding: 0;
        margin-bottom: 1.5rem;
        font-size: 0.82rem;
    }

    .breadcrumb-item a { color: var(--muted); text-decoration: none; transition: color 0.2s; }
    .breadcrumb-item a:hover { color: var(--navy); }
    .breadcrumb-item.active { color: var(--ink); font-weight: 500; }
    .breadcrumb-item + .breadcrumb-item::before { color: var(--border); }

    /* ── ORDER HEADER ── */
    .order-header {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .order-header-left h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 0.3rem;
    }

    .order-header-left p {
        font-size: 0.82rem;
        color: var(--muted);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* Status badge */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 1rem;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .badge-status .dot { width: 8px; height: 8px; border-radius: 50%; }
    .badge-status.pending   { background: #fffff0; color: #744210; border: 1.5px solid #fefcbf; }
    .badge-status.pending .dot   { background: #ecc94b; }
    .badge-status.confirmed { background: #ebf8ff; color: #2b6cb0; border: 1.5px solid #bee3f8; }
    .badge-status.confirmed .dot { background: #4299e1; }
    .badge-status.shipped   { background: #f0f4ff; color: #553c9a; border: 1.5px solid #c3dafe; }
    .badge-status.shipped .dot   { background: #805ad5; }
    .badge-status.completed { background: #f0fff4; color: #276749; border: 1.5px solid #c6f6d5; }
    .badge-status.completed .dot { background: #48bb78; }
    .badge-status.cancelled { background: #fff5f5; color: #9b2c2c; border: 1.5px solid #fed7d7; }
    .badge-status.cancelled .dot { background: #e53e3e; }

    /* ── DETAIL GRID ── */
    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.25rem;
        align-items: start;
    }

    @media (max-width: 991px) { .detail-layout { grid-template-columns: 1fr; } }

    /* ── INFO CARD ── */
    .info-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .info-card:last-child { margin-bottom: 0; }

    .info-card-header {
        padding: 0.9rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--navy);
        letter-spacing: 0.3px;
    }

    .info-card-header i { font-size: 0.95rem; }
    .info-card-body { padding: 1.25rem 1.5rem; }

    /* Info rows */
    .info-row {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
    }

    .info-row:last-child { margin-bottom: 0; }
    .info-row .key { color: var(--muted); min-width: 110px; flex-shrink: 0; font-size: 0.82rem; }
    .info-row .val { color: var(--ink); font-weight: 500; }

    /* Address box */
    .address-box {
        background: var(--soft);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.85rem 1rem;
        font-size: 0.875rem;
        color: var(--ink);
        line-height: 1.65;
        margin-top: 0.5rem;
    }

    /* Payment badge */
    .badge-payment {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.28rem 0.75rem;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .badge-payment.transfer { background: #ebf8ff; color: #2b6cb0; }
    .badge-payment.cod      { background: #f0fff4; color: #276749; }

    /* Proof button */
    .btn-proof {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: white;
        color: var(--navy);
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 0.45rem 1rem;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        margin-top: 0.5rem;
    }

    .btn-proof:hover { border-color: var(--navy); background: var(--navy); color: white; }

    /* ── PRODUCTS TABLE ── */
    .products-table-wrap {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .products-table { width: 100%; border-collapse: collapse; }

    .products-table thead th {
        background: var(--soft);
        padding: 0.75rem 1.25rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
    }

    .products-table tbody td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
        font-size: 0.875rem;
    }

    .products-table tbody tr:last-child td { border-bottom: none; }

    .product-cell { display: flex; align-items: center; gap: 0.85rem; }

    .product-thumb {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        border: 1.5px solid var(--border);
        flex-shrink: 0;
    }

    .product-cell-name { font-weight: 600; color: var(--navy); font-size: 0.875rem; }
    .product-cell-cat  { font-size: 0.75rem; color: var(--muted); }

    .products-table tfoot td {
        padding: 0.85rem 1.25rem;
        background: var(--soft);
        border-top: 1.5px solid var(--border);
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--navy);
    }

    /* ── TIMELINE ── */
    .timeline { padding: 0.25rem 0; }

    .timeline-item {
        display: flex;
        gap: 1rem;
        padding: 0.6rem 0;
        position: relative;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 28px;
        bottom: -8px;
        width: 2px;
        background: var(--border);
    }

    .tl-dot {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2px solid var(--border);
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 0.15rem;
        z-index: 1;
    }

    .tl-dot.done { border-color: #48bb78; background: #f0fff4; }
    .tl-dot.done i { color: #48bb78; font-size: 0.7rem; }
    .tl-dot.current { border-color: var(--accent); background: #fffff0; }
    .tl-dot.current i { color: var(--accent); font-size: 0.7rem; }
    .tl-dot.pending-tl { border-color: var(--border); background: var(--soft); }

    .tl-content .tl-label { font-size: 0.875rem; font-weight: 600; color: var(--ink); }
    .tl-content .tl-time  { font-size: 0.75rem; color: var(--muted); margin-top: 0.1rem; }

    /* ── BACK BUTTON ── */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        color: var(--navy);
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 0.6rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        margin-bottom: 1.5rem;
    }

    .btn-back:hover { border-color: var(--navy); color: var(--navy); background: var(--soft); }

    /* ── MOBILE PRODUCT LIST ── */
    .order-prod-mobile { display: none; }
    .order-prod-card {
        padding: 1rem;
        border-bottom: 1px solid var(--border);
    }
    .order-prod-card:last-child { border-bottom: none; }
    .order-prod-info { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
    .order-prod-details { display: flex; justify-content: space-between; font-size: 0.85rem; }
    .order-prod-label { color: var(--muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 600; }

    @media (max-width: 767px) {
        .products-table-wrap table { display: none; }
        .order-prod-mobile { display: block; }
        .order-header { padding: 1.25rem; text-align: center; justify-content: center; }
        .order-header-left h2 { font-size: 1.2rem; }
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">Semua Pesanan</a></li>
        <li class="breadcrumb-item active">#{{ $order->order_number }}</li>
    </ol>
</nav>

{{-- Order Header --}}
<div class="order-header">
    <div class="order-header-left">
        <h2>Pesanan #{{ $order->order_number }}</h2>
        <p>
            <i class="bi bi-calendar3"></i>
            {{ $order->created_at->format('d M Y, H:i') }} · {{ $order->created_at->diffForHumans() }}
        </p>
    </div>
    <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap">
        @switch($order->status)
            @case('pending')
                <span class="badge-status pending"><span class="dot"></span> Pending</span>
                @break
            @case('confirmed')
                <span class="badge-status confirmed"><span class="dot"></span> Confirmed</span>
                @break
            @case('shipped')
                <span class="badge-status shipped"><span class="dot"></span> Shipped</span>
                @break
            @case('completed')
                <span class="badge-status completed"><span class="dot"></span> Completed</span>
                @break
            @case('cancelled')
                <span class="badge-status cancelled"><span class="dot"></span> Cancelled</span>
                @break
        @endswitch
        <a href="{{ route('admin.orders') }}" class="btn-back" style="margin-bottom:0">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- ── LAYOUT ── --}}
<div class="detail-layout">

    {{-- LEFT COLUMN --}}
    <div>

        {{-- Products --}}
        <div class="products-table-wrap">
            <div class="info-card-header" style="padding:0.9rem 1.25rem">
                <i class="bi bi-box-seam"></i> Daftar Produk
                <span style="margin-left:auto;background:var(--soft);color:var(--muted);font-size:0.72rem;font-weight:600;padding:2px 8px;border-radius:20px">
                    {{ $order->items->count() }} item
                </span>
            </div>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Penjual</th>
                        <th style="text-align:center">Harga</th>
                        <th style="text-align:center">Qty</th>
                        <th style="text-align:right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="product-cell">
                                <img src="{{ $item->product->image_url }}"
                                     class="product-thumb" alt="{{ $item->product->name }}">
                                <div>
                                    <div class="product-cell-name">{{ $item->product->name }}</div>
                                    <div class="product-cell-cat">{{ $item->product->category->name ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:0.85rem;color:var(--muted)">{{ $item->seller->name }}</td>
                        <td style="text-align:center;font-size:0.85rem">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align:center;font-weight:600">{{ $item->quantity }}</td>
                        <td style="text-align:right;font-weight:700;color:var(--navy)">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right">Total Pembayaran</td>
                        <td style="text-align:right;font-family:'Playfair Display',serif;font-size:1.05rem">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            {{-- Mobile Product List --}}
            <div class="order-prod-mobile">
                @foreach($order->items as $item)
                    <div class="order-prod-card">
                        <div class="order-prod-info">
                            <img src="{{ $item->product->image_url }}"
                                 class="product-thumb" alt="{{ $item->product->name }}">
                            <div style="flex:1">
                                <div class="product-cell-name">{{ $item->product->name }}</div>
                                <div class="product-cell-cat">{{ $item->seller->name }}</div>
                            </div>
                        </div>
                        <div class="order-prod-details mb-2">
                             <div class="d-flex flex-column">
                                <span class="order-prod-label">Harga</span>
                                <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                             </div>
                             <div class="d-flex flex-column text-center">
                                <span class="order-prod-label">Qty</span>
                                <span>{{ $item->quantity }}</span>
                             </div>
                             <div class="d-flex flex-column text-end">
                                <span class="order-prod-label">Subtotal</span>
                                <span class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                             </div>
                        </div>
                    </div>
                @endforeach
                <div class="p-3 bg-soft d-flex justify-content-between align-items-center">
                    <span class="order-prod-label">Total Pembayaran</span>
                    <span class="fw-bold text-navy" style="font-family:'Playfair Display',serif;font-size:1.1rem">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Shipping Info --}}
        <div class="info-card">
            <div class="info-card-header"><i class="bi bi-truck"></i> Informasi Pengiriman</div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="key">Metode Bayar</span>
                    <span class="val">
                        @if($order->payment_method == 'transfer_bank')
                            <span class="badge-payment transfer"><i class="bi bi-bank"></i> Transfer Bank</span>
                        @else
                            <span class="badge-payment cod"><i class="bi bi-cash"></i> COD</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="key">Alamat Kirim</span>
                    <span class="val" style="flex:1"></span>
                </div>
                <div class="address-box">{{ $order->shipping_address }}</div>

                @if($order->payment_proof)
                    <div style="margin-top:1rem">
                        <div style="font-size:0.8rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.4rem">Bukti Pembayaran</div>
                        <a href="{{ asset('storage/payments/' . $order->payment_proof) }}" target="_blank" class="btn-proof">
                            <i class="bi bi-file-image"></i> Lihat Bukti Bayar
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN --}}
    <div>

        {{-- Buyer Info --}}
        <div class="info-card">
            <div class="info-card-header"><i class="bi bi-person-circle"></i> Informasi Pembeli</div>
            <div class="info-card-body">
                <div style="display:flex;align-items:center;gap:0.85rem;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid var(--border)">
                    <div style="width:42px;height:42px;background:var(--navy);border-radius:12px;display:flex;align-items:center;justify-content:center;color:var(--accent);font-size:1.1rem;flex-shrink:0">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div style="font-weight:700;color:var(--navy);font-size:0.9rem">{{ $order->buyer->name }}</div>
                        <div style="font-size:0.78rem;color:var(--muted)">{{ $order->buyer->email }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <span class="key">Telepon</span>
                    <span class="val">{{ $order->buyer->phone ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="key">Bergabung</span>
                    <span class="val">{{ $order->buyer->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="info-card">
            <div class="info-card-header"><i class="bi bi-receipt"></i> Ringkasan Pesanan</div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="key">No. Order</span>
                    <span class="val" style="font-family:monospace;font-weight:700">#{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="key">Tanggal</span>
                    <span class="val">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="key">Jam</span>
                    <span class="val">{{ $order->created_at->format('H:i:s') }}</span>
                </div>
                <div class="info-row">
                    <span class="key">Total Item</span>
                    <span class="val">{{ $order->items->count() }} produk</span>
                </div>
                <div style="border-top:1.5px solid var(--border);margin-top:0.75rem;padding-top:0.75rem">
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <span style="font-size:0.82rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.5px">Total</span>
                        <span style="font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:700;color:var(--navy)">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="info-card">
            <div class="info-card-header"><i class="bi bi-clock-history"></i> Timeline Pesanan</div>
            <div class="info-card-body">
                @php
                    $steps = ['pending','confirmed','shipped','completed'];
                    $currentIdx = array_search($order->status, $steps);
                    if ($order->status == 'cancelled') $currentIdx = -1;
                @endphp
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="tl-dot done"><i class="bi bi-check-lg"></i></div>
                        <div class="tl-content">
                            <div class="tl-label">Pesanan Dibuat</div>
                            <div class="tl-time">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                    @foreach(['confirmed' => 'Dikonfirmasi', 'shipped' => 'Dikirim', 'completed' => 'Selesai'] as $step => $label)
                        @php
                            $stepIdx = array_search($step, $steps);
                            $isDone = $currentIdx !== false && $currentIdx >= $stepIdx;
                            $isCurrent = $currentIdx === $stepIdx;
                        @endphp
                        <div class="timeline-item">
                            <div class="tl-dot {{ $isDone ? 'done' : ($isCurrent ? 'current' : 'pending-tl') }}">
                                @if($isDone)
                                    <i class="bi bi-check-lg"></i>
                                @elseif($isCurrent)
                                    <i class="bi bi-circle-fill" style="font-size:0.5rem"></i>
                                @endif
                            </div>
                            <div class="tl-content">
                                <div class="tl-label" style="{{ !$isDone && !$isCurrent ? 'color:var(--muted)' : '' }}">{{ $label }}</div>
                                @if($isDone)
                                    <div class="tl-time">{{ $order->updated_at->format('d M Y, H:i') }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if($order->status == 'cancelled')
                        <div class="timeline-item">
                            <div class="tl-dot" style="border-color:#e53e3e;background:#fff5f5">
                                <i class="bi bi-x-lg" style="color:#e53e3e;font-size:0.65rem"></i>
                            </div>
                            <div class="tl-content">
                                <div class="tl-label" style="color:#9b2c2c">Dibatalkan</div>
                                <div class="tl-time">{{ $order->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

@endsection