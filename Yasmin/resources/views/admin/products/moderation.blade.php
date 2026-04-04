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
    .seller-count { font-size: 0.72rem; color: var(--muted); }

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
    .btn-action.delete:hover  { border-color: #e53e3e; color: #9b2c2c; background: #fff5f5; }

    /* Expand description */
    .desc-toggle {
        background: none;
        border: none;
        color: var(--navy);
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.2rem;
    }

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

    .textarea-styled:focus {
        border-color: var(--navy);
        background: white;
        box-shadow: 0 0 0 3px rgba(15,36,68,0.08);
        outline: none;
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
    .btn-modal-confirm.danger:hover { background: #c53030; }
    .btn-modal-confirm.success { background: #38a169; }
    .btn-modal-confirm.success:hover { background: #276749; }

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
        @if(request('status') == 'pending' && $pendingCount > 0)
            <span style="font-size:0.8rem;color:#744210;background:#fffff0;border:1px solid #fefcbf;border-radius:8px;padding:0.3rem 0.75rem;font-weight:600">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ $pendingCount }} menunggu review
            </span>
        @endif
    </div>

    <div style="overflow-x:auto">
        <table class="mod-table">
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
                    <td style="color:var(--muted);font-size:0.8rem">{{ $products->firstItem() + $index }}</td>

                    {{-- Product --}}
                    <td>
                        <div class="product-cell">
                            <img src="{{ asset('storage/products/' . $product->image) }}"
                                 class="product-thumb" alt="{{ $product->name }}">
                            <div>
                                <div class="product-name">{{ $product->name }}</div>
                                <button class="desc-toggle" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#desc{{ $product->id }}">
                                    <i class="bi bi-chevron-down" style="font-size:0.7rem"></i> Deskripsi
                                </button>
                                <div class="collapse" id="desc{{ $product->id }}">
                                    <p style="font-size:0.78rem;color:var(--muted);margin-top:0.3rem;max-width:220px;line-height:1.5">
                                        {{ Str::limit($product->description, 120) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Seller --}}
                    <td>
                        <div class="seller-cell">
                            <span class="seller-name">{{ $product->user->name }}</span>
                            <span class="seller-email">{{ $product->user->email }}</span>
                            @php $sellerProductCount = \App\Models\Product::where('user_id', $product->user_id)->count(); @endphp
                            <span class="seller-count"><i class="bi bi-box me-1"></i>{{ $sellerProductCount }} produk total</span>
                        </div>
                    </td>

                    {{-- Category --}}
                    <td>
                        <span style="font-size:0.82rem;color:var(--ink)">{{ $product->category->name }}</span>
                    </td>

                    {{-- Price --}}
                    <td>
                        <span style="font-weight:700;color:var(--navy);font-size:0.875rem">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- Condition --}}
                    <td>
                        <span class="badge-cond {{ $product->condition }}">
                            {{ $product->condition == 'baru' ? 'Baru' : ($product->condition == 'seperti_baru' ? 'Seperti Baru' : 'Bekas') }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($product->status == 'pending')
                            <span class="badge-status pending"><span class="dot"></span> Pending</span>
                        @elseif($product->status == 'tersedia')
                            <span class="badge-status approved"><span class="dot"></span> Disetujui</span>
                        @else
                            <span class="badge-status rejected"><span class="dot"></span> Ditolak</span>
                        @endif
                    </td>

                    {{-- Date --}}
                    <td>
                        <span style="font-size:0.8rem;color:var(--muted)">
                            {{ $product->created_at->format('d M Y') }}<br>
                            <span style="font-size:0.72rem">{{ $product->created_at->diffForHumans() }}</span>
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="action-group">
                            {{-- Detail --}}
                            <button class="btn-action view" type="button"
                                    data-bs-toggle="modal" data-bs-target="#detailModal{{ $product->id }}"
                                    title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </button>

                            @if($product->status == 'pending')
                                {{-- Approve --}}
                                <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn-action approve" type="submit" title="Setujui">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>

                                {{-- Reject --}}
                                <button class="btn-action reject" type="button"
                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $product->id }}"
                                        title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus produk ini permanen?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action delete" type="submit" title="Hapus">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- ── DETAIL MODAL ── --}}
                <div class="modal fade" id="detailModal{{ $product->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i>Detail Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="detail-product-card">
                                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}">
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
                                    <div class="detail-field">
                                        <label>Kategori</label>
                                        <p>{{ $product->category->name }}</p>
                                    </div>
                                    <div class="detail-field">
                                        <label>Kondisi</label>
                                        <p>{{ $product->condition == 'baru' ? 'Baru' : ($product->condition == 'seperti_baru' ? 'Seperti Baru' : 'Bekas') }}</p>
                                    </div>
                                    <div class="detail-field">
                                        <label>Status</label>
                                        <p>
                                            @if($product->status == 'pending')
                                                <span class="badge-status pending"><span class="dot"></span> Pending</span>
                                            @elseif($product->status == 'tersedia')
                                                <span class="badge-status approved"><span class="dot"></span> Disetujui</span>
                                            @else
                                                <span class="badge-status rejected"><span class="dot"></span> Ditolak</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="detail-field">
                                        <label>Tanggal Upload</label>
                                        <p>{{ $product->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="detail-field">
                                        <label>Penjual</label>
                                        <p>{{ $product->user->name }}</p>
                                    </div>
                                    <div class="detail-field">
                                        <label>Email Penjual</label>
                                        <p>{{ $product->user->email }}</p>
                                    </div>
                                    <div class="detail-field">
                                        <label>Status Akun Penjual</label>
                                        <p>
                                            <span class="badge-status approved"><span class="dot"></span> Seller Aktif</span>
                                        </p>
                                    </div>
                                    <div class="detail-field">
                                        <label>Total Produk Penjual</label>
                                        <p>{{ $sellerProductCount }} produk</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                @if($product->status == 'pending')
                                    <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn-modal-confirm success">
                                            <i class="bi bi-check-lg me-1"></i> Setujui Produk
                                        </button>
                                    </form>
                                    <button type="button" class="btn-modal-confirm danger"
                                            data-bs-dismiss="modal"
                                            onclick="setTimeout(() => document.getElementById('rejectTrigger{{ $product->id }}').click(), 300)">
                                        <i class="bi bi-x-lg me-1"></i> Tolak Produk
                                    </button>
                                @endif
                                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── REJECT MODAL ── --}}
                <button id="rejectTrigger{{ $product->id }}" class="d-none" type="button"
                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $product->id }}"></button>

                <div class="modal fade" id="rejectModal{{ $product->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="bi bi-x-circle me-2" style="color:#e53e3e"></i>Tolak Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="detail-product-card" style="margin-bottom:1rem">
                                        <img src="{{ asset('storage/products/' . $product->image) }}"
                                             style="width:56px;height:56px;border-radius:10px;object-fit:cover;border:1.5px solid var(--border)"
                                             alt="{{ $product->name }}">
                                        <div>
                                            <div style="font-weight:700;color:var(--navy);font-size:0.9rem">{{ $product->name }}</div>
                                            <div style="font-size:0.8rem;color:var(--muted)">oleh {{ $product->user->name }}</div>
                                            <div style="font-size:0.85rem;font-weight:600;color:var(--navy);margin-top:0.25rem">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>

                                    <label style="font-size:0.78rem;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;color:var(--muted);display:block;margin-bottom:0.5rem">
                                        Alasan Penolakan <span style="color:#e53e3e">*</span>
                                    </label>
                                    <textarea name="note" class="textarea-styled" rows="4"
                                              placeholder="Contoh: Foto produk tidak jelas, deskripsi tidak lengkap, harga tidak sesuai kondisi..."
                                              required></textarea>
                                    <p style="font-size:0.78rem;color:var(--muted);margin-top:0.5rem;margin-bottom:0">
                                        <i class="bi bi-info-circle me-1"></i> Alasan ini akan dikirim ke penjual sebagai notifikasi.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn-modal-confirm danger">
                                        <i class="bi bi-x-lg me-1"></i> Konfirmasi Tolak
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

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

    {{-- Pagination --}}
    <div class="pagination-wrap">
        <span class="pagination-info">
            Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk
        </span>
        {{ $products->withQueryString()->links() }}
    </div>
</div>

@endsection