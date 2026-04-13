@extends('layouts.admin')

@section('title', 'Moderasi Produk - Admin')
@section('page-title', 'Moderasi Produk')

@push('styles')
<style>
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

    .filter-actions {
        display: flex;
        gap: 0.5rem;
        align-items: flex-end;
    }

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
        transition: all 0.2s;
        text-decoration: none;
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
        transition: all 0.2s;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-filter-ghost:hover { border-color: var(--navy); color: var(--navy); }

    /* ── STATS ROW ── */
    .stats-row {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .stat-chip {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.6rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--ink);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .stat-chip:hover { border-color: var(--navy); color: var(--navy); }
    .stat-chip.active-all    { border-color: var(--navy); background: var(--navy); color: white; }
    .stat-chip.active-pending { border-color: #d69e2e; background: #fffff0; color: #744210; }
    .stat-chip.active-approved { border-color: #276749; background: #f0fff4; color: #276749; }
    .stat-chip.active-rejected { border-color: #9b2c2c; background: #fff5f5; color: #9b2c2c; }

    .stat-chip .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dot-all     { background: var(--navy); }
    .dot-pending  { background: #ecc94b; }
    .dot-approved { background: #48bb78; }
    .dot-rejected { background: #e53e3e; }

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
        gap: 1rem;
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

    .table-card-header .count-badge {
        background: var(--soft);
        color: var(--muted);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
    }

    /* ── TABLE ── */
    .mod-table { width: 100%; border-collapse: collapse; }

    .mod-table thead th {
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

    .mod-table thead th:first-child { border-radius: 0; padding-left: 1.5rem; }
    .mod-table thead th:last-child  { padding-right: 1.5rem; }

    .mod-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .mod-table tbody tr:last-child { border-bottom: none; }
    .mod-table tbody tr:hover { background: #fafaf9; }

    .mod-table tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        font-size: 0.875rem;
        color: var(--ink);
    }

    .mod-table tbody td:first-child { padding-left: 1.5rem; }
    .mod-table tbody td:last-child  { padding-right: 1.5rem; }

    /* Product cell */
    .product-cell {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .product-thumb {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        border: 1.5px solid var(--border);
        flex-shrink: 0;
    }

    .product-name {
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--navy);
        margin-bottom: 0.15rem;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-meta {
        font-size: 0.75rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* Seller cell */
    .seller-cell { display: flex; flex-direction: column; gap: 0.1rem; }
    .seller-name { font-weight: 600; font-size: 0.85rem; }
    .seller-email { font-size: 0.75rem; color: var(--muted); }

    /* Condition badge */
    .badge-cond {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .badge-cond.baru        { background: #ebf8ff; color: #2b6cb0; }
    .badge-cond.seperti_baru{ background: #f0fff4; color: #276749; }
    .badge-cond.bekas       { background: var(--soft); color: var(--muted); border: 1px solid var(--border); }

    /* Status badge */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-status .dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge-status.pending  { background: #fffff0; color: #744210; }
    .badge-status.pending .dot  { background: #ecc94b; }
    .badge-status.approved { background: #f0fff4; color: #276749; }
    .badge-status.approved .dot { background: #48bb78; }
    .badge-status.rejected { background: #fff5f5; color: #9b2c2c; }
    .badge-status.rejected .dot { background: #e53e3e; }

    /* Action buttons */
    .action-group { display: flex; align-items: center; gap: 0.4rem; }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.18s;
        text-decoration: none;
        color: var(--ink);
    }

    .btn-action:hover { transform: translateY(-1px); }
    .btn-action.view:hover    { border-color: #4299e1; color: #4299e1; background: #ebf8ff; }
    .btn-action.approve:hover { border-color: #48bb78; color: #276749; background: #f0fff4; }
    .btn-action.reject:hover  { border-color: #fc8181; color: #9b2c2c; background: #fff5f5; }

    /* Empty state */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--border);
        display: block;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: var(--muted);
        font-size: 0.9rem;
        margin: 0;
    }

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

    .pagination-info {
        font-size: 0.8rem;
        color: var(--muted);
    }

    /* ── MODALS ── */
    .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .modal-header .modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--navy);
    }

    .modal-body { padding: 1.5rem; }
    .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); }

    /* Detail modal product card */
    .detail-product-card {
        display: flex;
        gap: 1rem;
        background: var(--soft);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.25rem;
    }

    .detail-product-card img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1.5px solid var(--border);
    }

    .detail-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
        margin-bottom: 1.25rem;
    }

    .detail-field label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--muted);
        display: block;
        margin-bottom: 0.25rem;
    }

    .detail-field p {
        font-size: 0.875rem;
        color: var(--ink);
        font-weight: 500;
        margin: 0;
    }

    .textarea-styled {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.7rem 1rem;
        font-size: 0.875rem;
        width: 100%;
        resize: vertical;
        background: var(--soft);
        color: var(--ink);
        transition: all 0.2s;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-modal-confirm {
        background: var(--navy);
        color: white;
        border: none;
        border-radius: 9px;
        padding: 0.6rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-modal-confirm:hover { background: var(--navy-mid); color: white; }
    .btn-modal-confirm.danger { background: #e53e3e; }
    .btn-modal-confirm.success { background: #38a169; }

    .btn-modal-cancel {
        background: white;
        color: var(--muted);
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 0.6rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-modal-cancel:hover { border-color: var(--ink); color: var(--ink); }

    /* ── MOBILE CARD LIST ── */
    .prod-mobile-list { display: none; }
    .prod-card-mob {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin: 1rem;
    }
    .prod-card-header { display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem; }
    .prod-card-body { font-size: 0.85rem; }
    .prod-card-field { display: flex; justify-content: space-between; margin-bottom: 0.4rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.3rem; }
    .prod-card-label { color: var(--muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; }

    @media (max-width: 991px) {
        .mod-table-container { display: none; }
        .prod-mobile-list { display: block; }
        .filter-bar { padding: 1rem; }
        .stats-row { padding: 0 0.5rem; justify-content: center; }
        .table-card-header { flex-direction: column; align-items: stretch; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Moderasi Produk</h1>
    <p>Review dan kelola produk yang diupload oleh seller.</p>
</div>

{{-- ── STATS ROW ── --}}
@php
    $allCount      = \App\Models\Product::count();
    $pendingCount  = \App\Models\Product::where('status','pending')->count();
    $approvedCount = \App\Models\Product::where('status','tersedia')->count();
    $rejectedCount = \App\Models\Product::where('status','ditolak')->count();
    $currentStatus = request('status', '');
@endphp

<div class="stats-row">
    <a href="{{ route('admin.products.moderation') }}" class="stat-chip {{ $currentStatus == '' ? 'active-all' : '' }}">
        <span class="dot dot-all"></span> Semua <strong>{{ $allCount }}</strong>
    </a>
    <a href="{{ route('admin.products.moderation', ['status' => 'pending']) }}" class="stat-chip {{ $currentStatus == 'pending' ? 'active-pending' : '' }}">
        <span class="dot dot-pending"></span> Pending <strong>{{ $pendingCount }}</strong>
    </a>
    <a href="{{ route('admin.products.moderation', ['status' => 'tersedia']) }}" class="stat-chip {{ $currentStatus == 'tersedia' ? 'active-approved' : '' }}">
        <span class="dot dot-approved"></span> Disetujui <strong>{{ $approvedCount }}</strong>
    </a>
    <a href="{{ route('admin.products.moderation', ['status' => 'ditolak']) }}" class="stat-chip {{ $currentStatus == 'ditolak' ? 'active-rejected' : '' }}">
        <span class="dot dot-rejected"></span> Ditolak <strong>{{ $rejectedCount }}</strong>
    </a>
</div>

{{-- ── FILTER BAR ── --}}
<div class="filter-bar">
    <form action="{{ route('admin.products.moderation') }}" method="GET"
          style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:flex-end;width:100%">

        <div class="filter-group search-group">
            <label>Cari Produk / Penjual</label>
            <div style="position:relative">
                <i class="bi bi-search" style="position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:0.85rem"></i>
                <input type="text" name="search" class="form-control" style="padding-left:2.4rem"
                       placeholder="Nama produk atau penjual..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="filter-group">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                <option value="tersedia"  {{ request('status') == 'tersedia'  ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak"   {{ request('status') == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Kategori</label>
            <select name="category" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>Urutkan</label>
            <select name="sort" class="form-select">
                <option value="latest"  {{ request('sort','latest') == 'latest'  ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest"  {{ request('sort') == 'oldest'  ? 'selected' : '' }}>Terlama</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="price_low"  {{ request('sort') == 'price_low'  ? 'selected' : '' }}>Harga Terendah</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-filter"><i class="bi bi-funnel"></i> Filter</button>
            <a href="{{ route('admin.products.moderation') }}" class="btn-filter-ghost"><i class="bi bi-x-lg"></i> Reset</a>
        </div>
    </form>
</div>

{{-- ── TABLE ── --}}
<div class="table-card">
    <div class="table-card-header">
        <h6>
            <i class="bi bi-box-seam"></i> Daftar Produk
            <span class="count-badge">{{ $products->total() }} produk</span>
        </h6>
    </div>

    <div class="mod-table-container">
        <table class="mod-table" style="width:100%; overflow-x:auto;">
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>Produk</th>
                    <th>Penjual</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Upload</th>
                    <th style="width:120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $product)
                <tr>
                    <td>{{ $products->firstItem() + $index }}</td>
                    <td>
                        <div class="product-cell">
                            <img src="{{ $product->image_url }}" class="product-thumb">
                            <div>
                                <div class="product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                                <div class="product-meta">ID #{{ $product->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="seller-cell">
                            <span class="seller-name">{{ $product->user->name }}</span>
                            <span class="seller-email">{{ $product->user->email }}</span>
                        </div>
                    </td>
                    <td>{{ $product->category->name }}</td>
                    <td style="font-weight:600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge-cond {{ $product->condition }}">
                            {{ $product->condition == 'baru' ? 'Baru' : ($product->condition == 'seperti_baru' ? 'Spt Baru' : 'Bekas') }}
                        </span>
                    </td>
                    <td>
                        @if($product->status == 'pending')
                            <span class="badge-status pending"><span class="dot"></span> Pending</span>
                        @elseif($product->status == 'tersedia')
                            <span class="badge-status approved"><span class="dot"></span> Disetujui</span>
                        @else
                            <span class="badge-status rejected"><span class="dot"></span> Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-size:0.8rem;color:var(--muted)">
                            {{ $product->created_at->format('d/m/y') }}
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                             <button class="btn-action view" type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $product->id }}"
                                    title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            @if($product->status == 'pending')
                                <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <button class="btn-action approve" type="submit" title="Setujui">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <button class="btn-action reject" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rejectModal{{ $product->id }}"
                                        title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="bi bi-box-seam"></i>
                            <p>Tidak ada produk ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile List --}}
    <div class="prod-mobile-list">
        @forelse($products as $index => $product)
            <div class="prod-card-mob">
                <div class="prod-card-header">
                    <img src="{{ $product->image_url }}" class="product-thumb">
                    <div style="flex:1; min-width:0">
                        <div class="product-name" style="max-width:100%">{{ $product->name }}</div>
                        <div class="product-meta">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="prod-card-body">
                    <div class="prod-card-field">
                        <span class="prod-card-label">Penjual</span>
                        <span class="text-truncate">{{ $product->user->name }}</span>
                    </div>
                    <div class="prod-card-field">
                        <span class="prod-card-label">Status</span>
                        @if($product->status == 'pending')
                            <span class="text-warning fw-bold">PENDING</span>
                        @elseif($product->status == 'tersedia')
                            <span class="text-success fw-bold">APPROVED</span>
                        @else
                            <span class="text-danger fw-bold">REJECTED</span>
                        @endif
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-sm btn-outline-navy flex-grow-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $product->id }}">
                             Detail
                        </button>
                        @if($product->status == 'pending')
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="flex-grow-1">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success w-100">Approve</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
             <div class="empty-state">
                <i class="bi bi-box-seam"></i>
                <p>Tidak ada produk ditemukan</p>
            </div>
        @endforelse
    </div>

    {{-- Modals Loop --}}
    @foreach($products as $product)
        {{-- Detail Modal --}}
        <div class="modal fade" id="detailModal{{ $product->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i>Detail Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="detail-product-card">
                            <img src="{{ $product->image_url }}">
                            <div>
                                <div style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--navy);margin-bottom:0.3rem">
                                    {{ $product->name }}
                                </div>
                                <div style="font-size:1.1rem;font-weight:700;color:var(--navy);margin-bottom:0.5rem">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                                <p style="font-size:0.85rem;color:var(--muted);margin:0;line-height:1.6">{{ $product->description }}</p>
                            </div>
                        </div>
                        <div class="detail-info-grid">
                            <div class="detail-field"><label>Kategori</label><p>{{ $product->category->name }}</p></div>
                            <div class="detail-field"><label>Kondisi</label><p>{{ ucfirst($product->condition) }}</p></div>
                            <div class="detail-field"><label>Penjual</label><p>{{ $product->user->name }}</p></div>
                            <div class="detail-field"><label>Tanggal Upload</label><p>{{ $product->created_at->format('d M Y') }}</p></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if($product->status == 'pending')
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <button type="submit" class="btn-modal-confirm success">Setujui</button>
                            </form>
                            <button type="button" class="btn-modal-confirm danger" data-bs-dismiss="modal" 
                                    onclick="setTimeout(() => document.getElementById('rejectTrigger{{ $product->id }}').click(), 300)">Tolak</button>
                        @endif
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <button id="rejectTrigger{{ $product->id }}" class="d-none" type="button" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $product->id }}"></button>
        <div class="modal fade" id="rejectModal{{ $product->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label class="mb-2">Alasan Penolakan *</label>
                            <textarea name="note" class="textarea-styled" rows="4" required placeholder="Berikan alasan kenapa produk ditolak..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-modal-confirm danger">Konfirmasi Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <div class="pagination-wrap">
        <span class="pagination-info">
            Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk
        </span>
        {{ $products->withQueryString()->links() }}
    </div>
</div>

@endsection