@extends('layouts.app')

@section('title', 'Produk Saya - Seller')

@push('styles')
<style>
    :root {
        --navy: #0f2444;
        --navy-mid: #1a3a6b;
        --accent: #e8c547;
        --soft: #f5f3ef;
        --border: #e8e4dd;
        --muted: #8a8a8a;
        --ink: #0d0d0d;
    }

    body { background: var(--soft); font-family: 'DM Sans', sans-serif; }

    /* ── PAGE HEADER ── */
    .seller-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .seller-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--navy);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add {
        background: var(--navy);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.3rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-add:hover {
        background: var(--navy-mid);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(15,36,68,0.18);
    }

    /* ── ALERT ── */
    .alert-success-custom {
        background: #f0fff4;
        border: 1.5px solid #c6f6d5;
        border-radius: 12px;
        color: #276749;
        padding: 0.85rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1.5rem;
    }

    .alert-error-custom {
        background: #fff5f5;
        border: 1.5px solid #fed7d7;
        border-radius: 12px;
        color: #9b2c2c;
        padding: 0.85rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1.5rem;
    }

    /* ── TABLE CARD ── */
    .table-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(15,36,68,0.05);
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
    .prod-table { width: 100%; border-collapse: collapse; }

    .prod-table thead th {
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

    .prod-table thead th:first-child { padding-left: 1.5rem; }
    .prod-table thead th:last-child  { padding-right: 1.5rem; }

    .prod-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .prod-table tbody tr:last-child { border-bottom: none; }
    .prod-table tbody tr:hover { background: #fafaf9; }

    .prod-table tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        font-size: 0.875rem;
        color: var(--ink);
    }

    .prod-table tbody td:first-child { padding-left: 1.5rem; }
    .prod-table tbody td:last-child  { padding-right: 1.5rem; }

    /* Product cell */
    .product-cell { display: flex; align-items: center; gap: 0.85rem; }

    .product-thumb {
        width: 52px;
        height: 52px;
        border-radius: 11px;
        object-fit: cover;
        border: 1.5px solid var(--border);
        flex-shrink: 0;
        background: var(--soft);
    }

    .product-name {
        font-weight: 600;
        color: var(--navy);
        font-size: 0.875rem;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Condition badge */
    .badge-cond {
        display: inline-block;
        padding: 0.25rem 0.7rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .badge-cond.baru         { background: #ebf8ff; color: #2b6cb0; }
    .badge-cond.seperti_baru { background: #f0fff4; color: #276749; }
    .badge-cond.bekas        { background: var(--soft); color: var(--muted); border: 1px solid var(--border); }

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
    .badge-status.tersedia { background: #f0fff4; color: #276749; }
    .badge-status.tersedia .dot { background: #48bb78; }
    .badge-status.pending  { background: #fffff0; color: #744210; }
    .badge-status.pending .dot  { background: #ecc94b; }
    .badge-status.terjual  { background: #ebf8ff; color: #2b6cb0; }
    .badge-status.terjual .dot  { background: #4299e1; }
    .badge-status.ditolak  { background: #fff5f5; color: #9b2c2c; }
    .badge-status.ditolak .dot  { background: #e53e3e; }

    /* Action buttons */
    .action-group { display: flex; align-items: center; gap: 0.4rem; }

    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        border: 1.5px solid var(--border);
        background: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.18s;
        text-decoration: none;
        color: var(--ink);
    }

    .btn-action:hover { transform: translateY(-1px); }
    .btn-action.edit:hover   { border-color: #ecc94b; color: #744210; background: #fffff0; }
    .btn-action.delete:hover { border-color: #e53e3e; color: #9b2c2c; background: #fff5f5; }

    /* Empty state */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state .empty-icon {
        font-size: 3.5rem;
        color: var(--border);
        display: block;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        font-family: 'Playfair Display', serif;
        color: var(--navy);
        margin-bottom: 0.5rem;
    }

    .empty-state p { color: var(--muted); font-size: 0.875rem; margin-bottom: 1.25rem; }

    /* Pagination */
    .pagination-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info { font-size: 0.8rem; color: var(--muted); }

    /* Rejected note */
    .rejected-note {
        font-size: 0.75rem;
        color: #9b2c2c;
        margin-top: 0.2rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    /* ── MOBILE PRODUCT CARD ── */
    .product-mobile-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 1.15rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .prod-mob-top { display: flex; gap: 1rem; margin-bottom: 1rem; }
    .prod-mob-img { width: 70px; height: 70px; border-radius: 12px; object-fit: cover; }
    .prod-mob-info { flex: 1; }
    .prod-mob-name { font-weight: 700; color: var(--navy); margin-bottom: 0.2rem; }
    .prod-mob-price { font-weight: 800; color: var(--navy); font-size: 1rem; }
    
    .prod-mob-meta { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem; }

    .prod-mob-actions {
        display: flex;
        gap: 0.6rem;
        border-top: 1px solid var(--border);
        padding-top: 1rem;
    }

    .btn-mob-action {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.6rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .btn-mob-edit { background: #fffff0; color: #744210; border: 1.5px solid #ecc94b; }
    .btn-mob-delete { background: #fff5f5; color: #9b2c2c; border: 1.5px solid #feb2b2; }

    @media (max-width: 576px) {
        .seller-header h1 { font-size: 1.35rem; }
        .btn-add { width: 100%; justify-content: center; padding: 0.8rem; }
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    {{-- ── HEADER ── --}}
    <div class="seller-header">
        <h1><i class="bi bi-box-seam"></i> Produk Saya</h1>
        <a href="{{ route('seller.products.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
    </div>

    {{-- ── ALERTS ── --}}
    @if(session('success'))
        <div class="alert-success-custom">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error-custom">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- ── TABLE ── --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6>
                <i class="bi bi-box-seam"></i> Daftar Produk
                <span class="count-badge">{{ $products->total() }} produk</span>
            </h6>
        </div>

        <div class="d-none d-md-block">
            <table class="prod-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th style="width:90px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        {{-- Product --}}
                        <td>
                            <div class="product-cell">
                                <img src="{{ $product->image_url }}"
                                     class="product-thumb"
                                     alt="{{ $product->name }}">
                                <div>
                                    <div class="product-name">{{ $product->name }}</div>
                                    @if($product->status == 'ditolak' && $product->admin_note ?? false)
                                        <div class="rejected-note">
                                            <i class="bi bi-info-circle"></i> {{ Str::limit($product->admin_note, 40) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td style="font-size:0.85rem">{{ $product->category->name }}</td>

                        {{-- Price --}}
                        <td>
                            <span style="font-weight:700;color:var(--navy)">
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
                            <span class="badge-status {{ $product->status }}">
                                <span class="dot"></span>
                                @switch($product->status)
                                    @case('tersedia') Tersedia @break
                                    @case('pending')  Menunggu Review @break
                                    @case('terjual')  Terjual @break
                                    @case('ditolak')  Ditolak @break
                                @endswitch
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="action-group">
                                <a href="{{ route('seller.products.edit', $product) }}"
                                   class="btn-action edit" title="Edit Produk">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('seller.products.delete', $product) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus produk ini permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus Produk">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-box-seam empty-icon"></i>
                                <h5>Belum ada produk</h5>
                                <p>Yuk upload produk pertamamu dan mulai berjualan!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="d-md-none p-3">
            @forelse($products as $product)
            <div class="product-mobile-card">
                <div class="prod-mob-top">
                    <img src="{{ $product->image_url }}" class="prod-mob-img" alt="">
                    <div class="prod-mob-info">
                        <div class="prod-mob-name">{{ $product->name }}</div>
                        <div class="prod-mob-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="prod-mob-meta">
                    <span class="badge-cond {{ $product->condition }} shadow-sm">
                        {{ $product->condition == 'baru' ? 'Baru' : ($product->condition == 'seperti_baru' ? 'Sep. Baru' : 'Bekas') }}
                    </span>
                    <span class="badge-status {{ $product->status }} shadow-sm">
                        <span class="dot"></span>
                        @switch($product->status)
                            @case('tersedia') Tersedia @break
                            @case('pending')  Review @break
                            @case('terjual')  Terjual @break
                            @case('ditolak')  Ditolak @break
                        @endswitch
                    </span>
                    <span class="count-badge" style="background:#fff; border:1px solid var(--border)">{{ $product->category->name }}</span>
                </div>

                @if($product->status == 'ditolak' && $product->admin_note)
                    <div class="alert mt-2 mb-3 bg-danger-subtle border-0 py-2 small" style="border-radius:10px">
                        <i class="bi bi-exclamation-triangle me-1"></i> <b>Alasan:</b> {{ $product->admin_note }}
                    </div>
                @endif

                <div class="prod-mob-actions">
                    <a href="{{ route('seller.products.edit', $product) }}" class="btn-mob-action btn-mob-edit">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('seller.products.delete', $product) }}" 
                          method="POST" class="flex-grow-1"
                          onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-mob-action btn-mob-delete w-100 bg-transparent">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="bi bi-box-seam empty-icon"></i>
                <h5>Belum ada produk</h5>
                <p>Mulai berjualan sekarang!</p>
            </div>
            @endforelse
        </div>

        @if($products->hasPages())
        <div class="pagination-wrap">
            <span class="pagination-info">
                Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk
            </span>
            {{ $products->links() }}
        </div>
        @endif
    </div>

</div>
@endsection