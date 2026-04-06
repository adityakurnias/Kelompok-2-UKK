@extends('layouts.admin')

@section('title', 'Semua Pesanan - Admin')
@section('page-title', 'Semua Pesanan')

@push('styles')
<style>
    /* ── STATS GRID ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 1199px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 575px)  { .stats-grid { grid-template-columns: repeat(2, 1fr); } }

    .stat-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 1rem 1.1rem;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(15,36,68,0.08); }

    .stat-card .lbl {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .stat-card .lbl .dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }

    .stat-card .val {
        font-family: 'Playfair Display', serif;
        font-size: 1.7rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1;
    }

    .stat-card.active-filter { border-color: var(--navy); background: var(--navy); }
    .stat-card.active-filter .lbl { color: rgba(255,255,255,0.6); }
    .stat-card.active-filter .val { color: white; }
    .stat-card.active-filter .dot { background: var(--accent) !important; }

    /* ── FILTER BAR ── */
    .filter-bar {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        flex: 1;
        min-width: 140px;
    }

    .filter-group label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--muted);
    }

    .filter-group .form-control,
    .filter-group .form-select {
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 0.55rem 0.9rem;
        font-size: 0.875rem;
        background: var(--soft);
        color: var(--ink);
        transition: all 0.2s;
    }

    .filter-group .form-control:focus,
    .filter-group .form-select:focus {
        border-color: var(--navy);
        background: white;
        box-shadow: 0 0 0 3px rgba(15,36,68,0.08);
    }

    .filter-group.search-group { min-width: 220px; flex: 2; }
    .filter-actions { display: flex; gap: 0.5rem; align-items: flex-end; }

    .btn-filter {
        background: var(--navy);
        color: white;
        border: none;
        border-radius: 9px;
        padding: 0.57rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-filter:hover { background: var(--navy-mid); color: white; }

    .btn-filter-ghost {
        background: white;
        color: var(--muted);
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-filter-ghost:hover { border-color: var(--navy); color: var(--navy); }

    /* ── TABLE CARD ── */
    .table-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }

    .table-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-card-header h6 {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--navy);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .count-badge {
        background: var(--soft);
        color: var(--muted);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
    }

    /* ── TABLE ── */
    .orders-table { width: 100%; border-collapse: collapse; }

    .orders-table thead th {
        background: var(--soft);
        padding: 0.75rem 1rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .orders-table thead th:first-child { padding-left: 1.5rem; }
    .orders-table thead th:last-child  { padding-right: 1.5rem; }

    .orders-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .orders-table tbody tr:last-child { border-bottom: none; }
    .orders-table tbody tr:hover { background: #fafaf9; }

    .orders-table tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        font-size: 0.875rem;
        color: var(--ink);
    }

    .orders-table tbody td:first-child { padding-left: 1.5rem; }
    .orders-table tbody td:last-child  { padding-right: 1.5rem; }

    /* Order number */
    .order-num {
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--navy);
        font-family: monospace;
        letter-spacing: 0.5px;
    }

    /* Buyer cell */
    .buyer-name  { font-weight: 600; font-size: 0.875rem; }
    .buyer-email { font-size: 0.75rem; color: var(--muted); }

    /* Price */
    .price-val { font-weight: 700; color: var(--navy); }

    /* Payment badge */
    .badge-payment {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .badge-payment.transfer { background: #ebf8ff; color: #2b6cb0; }
    .badge-payment.cod      { background: #f0fff4; color: #276749; }

    /* Status badge */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.28rem 0.7rem;
        border-radius: 20px;
        font-size: 0.73rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-status .dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge-status.pending   { background: #fffff0; color: #744210; }
    .badge-status.pending .dot   { background: #ecc94b; }
    .badge-status.confirmed { background: #ebf8ff; color: #2b6cb0; }
    .badge-status.confirmed .dot { background: #4299e1; }
    .badge-status.shipped   { background: #f0f4ff; color: #553c9a; }
    .badge-status.shipped .dot   { background: #805ad5; }
    .badge-status.completed { background: #f0fff4; color: #276749; }
    .badge-status.completed .dot { background: #48bb78; }
    .badge-status.cancelled { background: #fff5f5; color: #9b2c2c; }
    .badge-status.cancelled .dot { background: #e53e3e; }

    .btn-detail {
        background: white;
        color: var(--navy);
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 0.4rem 0.9rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        border-color: var(--navy);
        background: var(--navy);
        color: white;
    }

    /* Empty */
    .empty-state { padding: 4rem 2rem; text-align: center; }
    .empty-state i { font-size: 3rem; color: var(--border); display: block; margin-bottom: 0.75rem; }
    .empty-state p { color: var(--muted); font-size: 0.9rem; margin: 0; }

    /* Pagination */
    .pagination-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .pagination-info { font-size: 0.8rem; color: var(--muted); }

    /* ── MOBILE CARD LIST ── */
    .order-mobile-list { display: none; }
    .order-card-mob {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin: 1rem;
    }
    .order-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; }
    .order-card-body { font-size: 0.85rem; }
    .order-card-field { display: flex; justify-content: space-between; margin-bottom: 0.4rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.3rem; }
    .order-card-label { color: var(--muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; }

    @media (max-width: 991px) {
        .orders-table-container { display: none; }
        .order-mobile-list { display: block; }
        .filter-bar { padding: 1rem; }
        .table-card-header { flex-direction: column; align-items: stretch; gap: 0.75rem; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Semua Pesanan</h1>
    <p>Pantau semua transaksi yang terjadi di platform.</p>
</div>

{{-- ── STAT CARDS ── --}}
@php $currentStatus = request('status', ''); @endphp
<div class="stats-grid">
    <a href="{{ route('admin.orders') }}" class="stat-card {{ $currentStatus == '' ? 'active-filter' : '' }}">
        <div class="lbl"><span class="dot" style="background:var(--navy)"></span> Total</div>
        <div class="val">{{ $totalOrders }}</div>
    </a>
    <a href="{{ route('admin.orders', ['status' => 'pending']) }}" class="stat-card {{ $currentStatus == 'pending' ? 'active-filter' : '' }}">
        <div class="lbl"><span class="dot" style="background:#ecc94b"></span> Pending</div>
        <div class="val">{{ $pendingOrders }}</div>
    </a>
    <a href="{{ route('admin.orders', ['status' => 'confirmed']) }}" class="stat-card {{ $currentStatus == 'confirmed' ? 'active-filter' : '' }}">
        <div class="lbl"><span class="dot" style="background:#4299e1"></span> Confirmed</div>
        <div class="val">{{ $confirmedOrders }}</div>
    </a>
    <a href="{{ route('admin.orders', ['status' => 'shipped']) }}" class="stat-card {{ $currentStatus == 'shipped' ? 'active-filter' : '' }}">
        <div class="lbl"><span class="dot" style="background:#805ad5"></span> Shipped</div>
        <div class="val">{{ $shippedOrders }}</div>
    </a>
    <a href="{{ route('admin.orders', ['status' => 'completed']) }}" class="stat-card {{ $currentStatus == 'completed' ? 'active-filter' : '' }}">
        <div class="lbl"><span class="dot" style="background:#48bb78"></span> Completed</div>
        <div class="val">{{ $completedOrders }}</div>
    </a>
    <a href="{{ route('admin.orders', ['status' => 'cancelled']) }}" class="stat-card {{ $currentStatus == 'cancelled' ? 'active-filter' : '' }}">
        <div class="lbl"><span class="dot" style="background:#e53e3e"></span> Cancelled</div>
        <div class="val">{{ $cancelledOrders }}</div>
    </a>
</div>

{{-- ── FILTER BAR ── --}}
<div class="filter-bar">
    <form action="{{ route('admin.orders') }}" method="GET"
          style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:flex-end;width:100%">

        <div class="filter-group search-group">
            <label>Cari Pesanan</label>
            <div style="position:relative">
                <i class="bi bi-search" style="position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:0.85rem"></i>
                <input type="text" name="search" class="form-control" style="padding-left:2.4rem"
                       placeholder="No. order atau nama pembeli..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="filter-group">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="shipped"   {{ request('status') == 'shipped'   ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Metode Bayar</label>
            <select name="payment" class="form-select">
                <option value="">Semua Metode</option>
                <option value="transfer_bank" {{ request('payment') == 'transfer_bank' ? 'selected' : '' }}>Transfer Bank</option>
                <option value="cod"           {{ request('payment') == 'cod'           ? 'selected' : '' }}>COD</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-filter"><i class="bi bi-funnel"></i> Filter</button>
            <a href="{{ route('admin.orders') }}" class="btn-filter-ghost"><i class="bi bi-x-lg"></i> Reset</a>
        </div>
    </form>
</div>

{{-- ── TABLE ── --}}
<div class="table-card">
    <div class="table-card-header">
        <h6>
            <i class="bi bi-cart-check"></i> Daftar Pesanan
            <span class="count-badge">{{ $orders->total() }} pesanan</span>
        </h6>
    </div>

    <div class="orders-table-container">
        <table class="orders-table" style="width:100%; overflow-x:auto;">
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>No. Order</th>
                    <th>Pembeli</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th style="width:90px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr>
                    <td style="color:var(--muted);font-size:0.8rem">{{ $orders->firstItem() + $index }}</td>
                    <td><span class="order-num">#{{ $order->order_number }}</span></td>
                    <td>
                        <div class="buyer-name">{{ $order->buyer->name }}</div>
                        <div class="buyer-email">{{ $order->buyer->email }}</div>
                    </td>
                    <td><span class="price-val">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></td>
                    <td>
                        <span class="badge-payment {{ $order->payment_method == 'transfer_bank' ? 'transfer' : 'cod' }}">
                            {{ $order->payment_method == 'transfer_bank' ? 'Transfer' : 'COD' }}
                        </span>
                    </td>
                    <td>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge-status pending"><span class="dot"></span> Pending</span> @break
                            @case('confirmed')
                                <span class="badge-status confirmed"><span class="dot"></span> Confirmed</span> @break
                            @case('shipped')
                                <span class="badge-status shipped"><span class="dot"></span> Shipped</span> @break
                            @case('completed')
                                <span class="badge-status completed"><span class="dot"></span> Completed</span> @break
                            @case('cancelled')
                                <span class="badge-status cancelled"><span class="dot"></span> Cancelled</span> @break
                        @endswitch
                    </td>
                    <td>
                        <span style="font-size:0.8rem;color:var(--muted)">
                            {{ $order->created_at->format('d/m/y') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.detail', $order->id) }}" class="btn-detail">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="bi bi-cart-x"></i>
                            <p>Tidak ada pesanan ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile List --}}
    <div class="order-mobile-list">
        @forelse($orders as $index => $order)
            <div class="order-card-mob">
                <div class="order-card-header">
                    <span class="order-num">#{{ $order->order_number }}</span>
                    @switch($order->status)
                         @case('pending')
                             <span class="badge bg-warning text-dark small" style="font-size:0.6rem">PENDING</span> @break
                         @case('confirmed')
                             <span class="badge bg-info small" style="font-size:0.6rem">CONFIRMED</span> @break
                         @case('shipped')
                             <span class="badge bg-primary small" style="font-size:0.6rem">SHIPPED</span> @break
                         @case('completed')
                             <span class="badge bg-success small" style="font-size:0.6rem">COMPLETED</span> @break
                         @case('cancelled')
                             <span class="badge bg-danger small" style="font-size:0.6rem">CANCELLED</span> @break
                    @endswitch
                </div>
                <div class="order-card-body">
                    <div class="order-card-field">
                        <span class="order-card-label">Pembeli</span>
                        <span class="text-truncate">{{ $order->buyer->name }}</span>
                    </div>
                    <div class="order-card-field">
                        <span class="order-card-label">Total</span>
                        <span class="price-val">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="order-card-field">
                        <span class="order-card-label">Metode</span>
                        <span>{{ $order->payment_method == 'transfer_bank' ? 'Transfer' : 'COD' }}</span>
                    </div>
                    <div class="order-card-field">
                        <span class="order-card-label">Tanggal</span>
                        <span>{{ $order->created_at->format('d/m/y') }}</span>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.orders.detail', $order->id) }}" class="btn btn-sm btn-outline-navy w-100">
                             <i class="bi bi-eye"></i> Detail Pesanan
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-cart-x"></i>
                <p>Tidak ada pesanan ditemukan</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrap">
        <span class="pagination-info">
            Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
        </span>
        {{ $orders->withQueryString()->links() }}
    </div>
</div>

@endsection