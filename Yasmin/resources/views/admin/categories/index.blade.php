@extends('layouts.admin')

@section('title', 'Kelola Kategori - Admin')
@section('page-title', 'Kelola Kategori')

@push('styles')
<style>
    /* ── FORM CARD ── */
    .add-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .add-card-header {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
        padding: 1rem 1.5rem;
        color: white;
        font-family: 'Playfair Display', serif;
        font-size: 0.95rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .add-card-body {
        padding: 1.25rem 1.5rem;
    }

    .add-form-row {
        display: flex;
        gap: 0.75rem;
        align-items: flex-end;
    }

    .add-form-group {
        flex: 1;
        min-width: 0;
    }

    .add-form-group label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--muted);
        display: block;
        margin-bottom: 0.35rem;
    }

    .add-form-group .form-control {
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 0.6rem 1rem;
        font-size: 0.875rem;
        background: var(--soft);
        color: var(--ink);
        transition: all 0.2s;
        width: 100%;
    }

    .add-form-group .form-control:focus {
        border-color: var(--navy);
        background: white;
        box-shadow: 0 0 0 3px rgba(15,36,68,0.08);
        outline: none;
    }

    .btn-add {
        background: var(--navy);
        color: white;
        border: none;
        border-radius: 9px;
        padding: 0.62rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-add:hover { background: var(--navy-mid); color: white; transform: translateY(-1px); }

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
    .cat-table { width: 100%; border-collapse: collapse; }

    .cat-table thead th {
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

    .cat-table thead th:first-child { padding-left: 1.5rem; }
    .cat-table thead th:last-child  { padding-right: 1.5rem; }

    .cat-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .cat-table tbody tr:last-child { border-bottom: none; }
    .cat-table tbody tr:hover { background: #fafaf9; }

    .cat-table tbody td {
        padding: 0.85rem 1rem;
        vertical-align: middle;
        font-size: 0.875rem;
        color: var(--ink);
    }

    .cat-table tbody td:first-child { padding-left: 1.5rem; }
    .cat-table tbody td:last-child  { padding-right: 1.5rem; }

    .cat-name { font-weight: 600; color: var(--navy); }

    .cat-slug {
        font-family: monospace;
        font-size: 0.78rem;
        color: var(--muted);
        background: var(--soft);
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid var(--border);
    }

    .cat-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.7rem;
        border-radius: 20px;
        font-size: 0.73rem;
        font-weight: 600;
        background: #ebf8ff;
        color: #2b6cb0;
    }

    /* Actions */
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
    .btn-action.edit:hover   { border-color: #ecc94b; color: #744210; background: #fffff0; }
    .btn-action.delete:hover { border-color: #e53e3e; color: #9b2c2c; background: #fff5f5; }

    /* Empty state */
    .empty-state { padding: 4rem 2rem; text-align: center; }
    .empty-state i { font-size: 3rem; color: var(--border); display: block; margin-bottom: 0.75rem; }
    .empty-state p { color: var(--muted); font-size: 0.9rem; margin: 0; }

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
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
    }

    .modal-header .modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: white;
    }

    .modal-header .btn-close { filter: invert(1); }
    .modal-body { padding: 1.5rem; }
    .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); gap: 0.5rem; }

    .modal-body label {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--muted);
        display: block;
        margin-bottom: 0.35rem;
    }

    .modal-body .form-control {
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 0.6rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .modal-body .form-control:focus {
        border-color: var(--navy);
        box-shadow: 0 0 0 3px rgba(15,36,68,0.08);
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
    .cat-mobile-list { display: none; }

    .cat-card-mob {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin: 0.75rem 1rem;
    }

    .cat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border);
    }

    .cat-card-header .cat-name {
        font-size: 0.95rem;
    }

    .cat-card-body { font-size: 0.85rem; }

    .cat-card-field {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.4rem;
        border-bottom: 1px dashed var(--border);
        padding-bottom: 0.3rem;
    }

    .cat-card-field:last-child { border-bottom: none; }

    .cat-card-label {
        color: var(--muted);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 991px) {
        .cat-table-container { display: none; }
        .cat-mobile-list { display: block; }
        .table-card-header { flex-direction: column; align-items: stretch; gap: 0.5rem; }
    }

    @media (max-width: 767px) {
        .add-card-body { padding: 1rem; }
        .add-form-row { flex-direction: column; }
        .btn-add { width: 100%; justify-content: center; }
    }

    @media (max-width: 575px) {
        .add-card-header { padding: 0.85rem 1rem; font-size: 0.85rem; }
        .cat-card-mob { margin: 0.5rem 0.75rem; padding: 0.85rem; }
        .cat-card-header .cat-name { font-size: 0.88rem; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Kelola Kategori</h1>
    <p>Tambah, edit, dan hapus kategori produk.</p>
</div>

{{-- Form Tambah Kategori --}}
<div class="add-card">
    <div class="add-card-header">
        <i class="bi bi-plus-circle"></i> Tambah Kategori Baru
    </div>
    <div class="add-card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="add-form-row">
                <div class="add-form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" class="form-control"
                           placeholder="Misal: Pakaian Pria" required>
                </div>
                <button type="submit" class="btn-add">
                    <i class="bi bi-plus-lg"></i> Tambah
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Table Card --}}
<div class="table-card">
    <div class="table-card-header">
        <h6>
            <i class="bi bi-tags"></i> Daftar Kategori
            <span class="count-badge">{{ $categories->count() }} kategori</span>
        </h6>
    </div>

    {{-- Desktop Table --}}
    <div class="cat-table-container">
        <table class="cat-table">
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Produk</th>
                    <th>Dibuat</th>
                    <th style="width:100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $category)
                <tr>
                    <td style="color:var(--muted);font-size:0.8rem">{{ $index + 1 }}</td>
                    <td><span class="cat-name">{{ $category->name }}</span></td>
                    <td><span class="cat-slug">{{ $category->slug }}</span></td>
                    <td>
                        <span class="cat-count-badge">
                            <i class="bi bi-box-seam"></i> {{ $category->products_count }} produk
                        </span>
                    </td>
                    <td>
                        <span style="font-size:0.8rem;color:var(--muted)">{{ $category->created_at->format('d M Y') }}</span>
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action edit" type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $category->id }}"
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.categories.delete', $category) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete"
                                        onclick="return confirm('Hapus kategori {{ $category->name }}?')"
                                        title="Hapus">
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
                            <i class="bi bi-folder-x"></i>
                            <p>Belum ada kategori</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Card List --}}
    <div class="cat-mobile-list">
        @forelse($categories as $index => $category)
            <div class="cat-card-mob">
                <div class="cat-card-header">
                    <span class="cat-name">{{ $category->name }}</span>
                    <span class="cat-count-badge">
                        <i class="bi bi-box-seam"></i> {{ $category->products_count }}
                    </span>
                </div>
                <div class="cat-card-body">
                    <div class="cat-card-field">
                        <span class="cat-card-label">Slug</span>
                        <span class="cat-slug">{{ $category->slug }}</span>
                    </div>
                    <div class="cat-card-field">
                        <span class="cat-card-label">Dibuat</span>
                        <span>{{ $category->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-sm btn-outline-warning flex-grow-1"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $category->id }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <form action="{{ route('admin.categories.delete', $category) }}"
                              method="POST" class="flex-grow-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                    onclick="return confirm('Hapus kategori {{ $category->name }}?')">
                                <i class="bi bi-trash3"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-folder-x"></i>
                <p>Belum ada kategori</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Edit Modals --}}
@foreach($categories as $category)
    <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Kategori</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ $category->name }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modal-confirm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection