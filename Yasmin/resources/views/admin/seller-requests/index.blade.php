@extends('layouts.admin')

@section('title', 'Seller Requests - Admin')
@section('page-title', 'Seller Requests')

@push('styles')
<style>
    /* ── STATS ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 767px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(15,36,68,0.08); }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-icon.yellow { background: #fffff0; color: #d69e2e; }
    .stat-icon.green  { background: #f0fff4; color: #276749; }
    .stat-icon.red    { background: #fff5f5; color: #9b2c2c; }

    .stat-body .lbl {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.2rem;
    }

    .stat-body .val {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1;
    }

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
        min-width: 160px;
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

    .filter-group.search-group { min-width: 240px; flex: 2; }

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
        transition: all 0.2s;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-filter-ghost:hover { border-color: var(--navy); color: var(--navy); }

    /* ── STATUS CHIPS ── */
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
        text-decoration: none;
        transition: all 0.2s;
    }

    .stat-chip:hover { border-color: var(--navy); color: var(--navy); }
    .stat-chip.active-all      { border-color: var(--navy); background: var(--navy); color: white; }
    .stat-chip.active-pending  { border-color: #d69e2e; background: #fffff0; color: #744210; }
    .stat-chip.active-approved { border-color: #276749; background: #f0fff4; color: #276749; }
    .stat-chip.active-rejected { border-color: #9b2c2c; background: #fff5f5; color: #9b2c2c; }

    .stat-chip .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .dot-all      { background: var(--navy); }
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
    .req-table { width: 100%; border-collapse: collapse; }

    .req-table thead th {
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

    .req-table thead th:first-child { padding-left: 1.5rem; }
    .req-table thead th:last-child  { padding-right: 1.5rem; }

    .req-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .req-table tbody tr:last-child { border-bottom: none; }
    .req-table tbody tr:hover { background: #fafaf9; }

    .req-table tbody td {
        padding: 1rem 1rem;
        vertical-align: middle;
        font-size: 0.875rem;
        color: var(--ink);
    }

    .req-table tbody td:first-child { padding-left: 1.5rem; }
    .req-table tbody td:last-child  { padding-right: 1.5rem; }

    /* Applicant cell */
    .applicant-cell { display: flex; align-items: center; gap: 0.75rem; }

    .applicant-avatar {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: var(--navy);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .applicant-name  { font-weight: 600; font-size: 0.875rem; color: var(--navy); }
    .applicant-email { font-size: 0.75rem; color: var(--muted); }

    /* Shop cell */
    .shop-name { font-weight: 600; font-size: 0.875rem; }
    .shop-wa   { font-size: 0.78rem; color: var(--muted); display: flex; align-items: center; gap: 0.3rem; margin-top: 0.1rem; }
    .shop-wa a { color: var(--muted); text-decoration: none; }
    .shop-wa a:hover { color: #25d366; }

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
    .btn-action.view:hover    { border-color: #4299e1; color: #2b6cb0; background: #ebf4ff; }
    .btn-action.approve:hover { border-color: #48bb78; color: #276749; background: #f0fff4; }
    .btn-action.reject:hover  { border-color: #e53e3e; color: #9b2c2c; background: #fff5f5; }

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

    /* Empty */
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
    }

    .modal-header .modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--navy);
    }

    .modal-body  { padding: 1.5rem; }
    .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); gap: 0.5rem; }

    /* Detail sections */
    .detail-section {
        margin-bottom: 1.25rem;
    }

    .detail-section-title {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .detail-field label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--muted);
        display: block;
        margin-bottom: 0.2rem;
    }

    .detail-field p {
        font-size: 0.875rem;
        color: var(--ink);
        font-weight: 500;
        margin: 0;
    }

    .detail-text-box {
        background: var(--soft);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.85rem 1rem;
        font-size: 0.875rem;
        color: var(--ink);
        line-height: 1.65;
    }

    /* Admin note box */
    .note-box {
        background: #ebf8ff;
        border: 1.5px solid #bee3f8;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        font-size: 0.875rem;
        color: #2c5282;
        line-height: 1.6;
        display: flex;
        gap: 0.6rem;
        align-items: flex-start;
    }

    /* Applicant card in modal */
    .applicant-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: var(--soft);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
    }

    .applicant-card .av {
        width: 48px;
        height: 48px;
        background: var(--navy);
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        font-size: 1.3rem;
        flex-shrink: 0;
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
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-modal-confirm:hover { background: var(--navy-mid); color: white; }
    .btn-modal-confirm.success { background: #38a169; }
    .btn-modal-confirm.success:hover { background: #276749; }
    .btn-modal-confirm.danger  { background: #e53e3e; }
    .btn-modal-confirm.danger:hover  { background: #c53030; }

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
    .req-mobile-list { display: none; }
    .req-card-mob {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin: 1rem;
    }
    .req-card-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
    .req-card-body { font-size: 0.85rem; }
    .req-card-field { display: flex; justify-content: space-between; margin-bottom: 0.4rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.3rem; }
    .req-card-label { color: var(--muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; }

    @media (max-width: 991px) {
        .req-table-container { display: none; }
        .req-mobile-list { display: block; }
        .filter-bar { padding: 1rem; }
        .stats-row { padding: 0 0.5rem; justify-content: center; }
        .table-card-header { flex-direction: column; align-items: stretch; gap: 0.75rem; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Seller Requests</h1>
    <p>Review dan kelola permohonan pengguna untuk menjadi seller.</p>
</div>

{{-- ── STAT CARDS ── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon yellow"><i class="bi bi-hourglass-split"></i></div>
        <div class="stat-body">
            <div class="lbl">Pending</div>
            <div class="val">{{ $totalPending }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
        <div class="stat-body">
            <div class="lbl">Disetujui</div>
            <div class="val">{{ $totalApproved }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="bi bi-x-circle"></i></div>
        <div class="stat-body">
            <div class="lbl">Ditolak</div>
            <div class="val">{{ $totalRejected }}</div>
        </div>
    </div>
</div>

{{-- ── STATUS CHIPS ── --}}
@php $currentStatus = request('status', ''); @endphp
<div class="stats-row">
    <a href="{{ route('admin.seller-requests') }}" class="stat-chip {{ $currentStatus == '' ? 'active-all' : '' }}">
        <span class="dot dot-all"></span> Semua <strong>{{ $totalPending + $totalApproved + $totalRejected }}</strong>
    </a>
    <a href="{{ route('admin.seller-requests', ['status' => 'pending']) }}" class="stat-chip {{ $currentStatus == 'pending' ? 'active-pending' : '' }}">
        <span class="dot dot-pending"></span> Pending <strong>{{ $totalPending }}</strong>
    </a>
    <a href="{{ route('admin.seller-requests', ['status' => 'approved']) }}" class="stat-chip {{ $currentStatus == 'approved' ? 'active-approved' : '' }}">
        <span class="dot dot-approved"></span> Disetujui <strong>{{ $totalApproved }}</strong>
    </a>
    <a href="{{ route('admin.seller-requests', ['status' => 'rejected']) }}" class="stat-chip {{ $currentStatus == 'rejected' ? 'active-rejected' : '' }}">
        <span class="dot dot-rejected"></span> Ditolak <strong>{{ $totalRejected }}</strong>
    </a>
</div>

{{-- ── FILTER BAR ── --}}
<div class="filter-bar">
    <form action="{{ route('admin.seller-requests') }}" method="GET"
          style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:flex-end;width:100%">

        <div class="filter-group search-group">
            <label>Cari Pemohon / Toko</label>
            <div style="position:relative">
                <i class="bi bi-search" style="position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:0.85rem"></i>
                <input type="text" name="search" class="form-control" style="padding-left:2.4rem"
                       placeholder="Nama pemohon atau nama toko..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="filter-group">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Urutkan</label>
            <select name="sort" class="form-select">
                <option value="latest" {{ request('sort','latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-filter"><i class="bi bi-funnel"></i> Filter</button>
            <a href="{{ route('admin.seller-requests') }}" class="btn-filter-ghost"><i class="bi bi-x-lg"></i> Reset</a>
        </div>
    </form>
</div>

{{-- ── TABLE & LIST ── --}}
<div class="table-card">
    <div class="table-card-header">
        <h6>
            <i class="bi bi-shop"></i> Daftar Permohonan
            <span class="count-badge">{{ $requests->total() }} request</span>
        </h6>
        @if($totalPending > 0)
            <span style="font-size:0.8rem;color:#744210;background:#fffff0;border:1px solid #fefcbf;border-radius:8px;padding:0.3rem 0.75rem;font-weight:600">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ $totalPending }} menunggu review
            </span>
        @endif
    </div>

    <div class="req-table-container">
        <table class="req-table" style="width:100%; overflow-x:auto;">
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>Pemohon</th>
                    <th>Toko</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th style="width:110px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $index => $req)
                <tr>
                    <td style="color:var(--muted);font-size:0.8rem">{{ $requests->firstItem() + $index }}</td>

                    {{-- Pemohon --}}
                    <td>
                        <div class="applicant-cell">
                            <div class="applicant-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <div class="applicant-name">{{ $req->user->name }}</div>
                                <div class="applicant-email">{{ $req->user->email }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Toko --}}
                    <td>
                        <div class="shop-name">{{ $req->shop_name }}</div>
                        <div class="shop-wa">
                            <i class="bi bi-whatsapp" style="color:#25d366"></i>
                            <a href="https://wa.me/{{ $req->whatsapp_number }}" target="_blank">
                                {{ $req->whatsapp_number }}
                            </a>
                        </div>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($req->status == 'pending')
                            <span class="badge-status pending"><span class="dot"></span> Pending</span>
                        @elseif($req->status == 'approved')
                            <span class="badge-status approved"><span class="dot"></span> Disetujui</span>
                        @else
                            <span class="badge-status rejected"><span class="dot"></span> Ditolak</span>
                        @endif
                    </td>

                    {{-- Tanggal --}}
                    <td>
                        <span style="font-size:0.8rem;color:var(--muted)">
                            {{ $req->created_at->format('d M Y') }}<br>
                            <span style="font-size:0.72rem">{{ $req->created_at->diffForHumans() }}</span>
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="action-group">
                            <button class="btn-action view" type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $req->id }}"
                                    title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </button>

                            @if($req->status == 'pending')
                                <button class="btn-action approve" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#approveModal{{ $req->id }}"
                                        title="Setujui">
                                    <i class="bi bi-check-lg"></i>
                                </button>

                                <button class="btn-action reject" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rejectModal{{ $req->id }}"
                                        title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Tidak ada seller request ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile List --}}
    {{-- Mobile List --}}
    <div class="req-mobile-list">
        @forelse($requests as $index => $req)
            <div class="req-card-mob">
                <div class="req-card-header">
                    <div class="applicant-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div class="applicant-name">{{ $req->user->name }}</div>
                        <div class="applicant-email text-truncate" style="max-width: 150px;">{{ $req->user->email }}</div>
                    </div>
                    <div class="ms-auto">
                        @if($req->status == 'pending')
                            <span class="badge bg-warning text-dark small" style="font-size:0.6rem">PENDING</span>
                        @elseif($req->status == 'approved')
                            <span class="badge bg-success small" style="font-size:0.6rem">APPROVED</span>
                        @else
                            <span class="badge bg-danger small" style="font-size:0.6rem">REJECTED</span>
                        @endif
                    </div>
                </div>
                <div class="req-card-body">
                    <div class="req-card-field">
                        <span class="req-card-label">Toko</span>
                        <span>{{ $req->shop_name }}</span>
                    </div>
                    <div class="req-card-field">
                        <span class="req-card-label">WhatsApp</span>
                        <span>{{ $req->whatsapp_number }}</span>
                    </div>
                    <div class="req-card-field">
                        <span class="req-card-label">Tanggal</span>
                        <span>{{ $req->created_at->format('d M y') }}</span>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-sm btn-outline-navy flex-grow-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $req->id }}">
                             Detail
                        </button>
                        @if($req->status == 'pending')
                             <button class="btn btn-sm btn-success flex-grow-1" data-bs-toggle="modal" data-bs-target="#approveModal{{ $req->id }}">
                                Approve
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>Tidak ada seller request ditemukan</p>
            </div>
        @endforelse
    </div>

    {{-- Modals Loop --}}
    @foreach($requests as $req)
        {{-- ── DETAIL MODAL ── --}}
        <div class="modal fade" id="detailModal{{ $req->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-shop me-2"></i>Detail Seller Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="applicant-card">
                            <div class="av"><i class="bi bi-person-fill"></i></div>
                            <div>
                                <div style="font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:var(--navy);margin-bottom:0.25rem">
                                    {{ $req->user->name }}
                                </div>
                                <div style="font-size:0.82rem;color:var(--muted);margin-bottom:0.3rem">
                                    {{ $req->user->email }} · {{ $req->user->phone ?? '—' }}
                                </div>
                                @if($req->status == 'pending')
                                    <span class="badge-status pending"><span class="dot"></span> Pending</span>
                                @elseif($req->status == 'approved')
                                    <span class="badge-status approved"><span class="dot"></span> Disetujui</span>
                                @else
                                    <span class="badge-status rejected"><span class="dot"></span> Ditolak</span>
                                @endif
                            </div>
                        </div>

                        <div class="detail-section">
                            <div class="detail-section-title"><i class="bi bi-shop"></i> Data Toko</div>
                            <div class="detail-grid">
                                <div class="detail-field">
                                    <label>Nama Toko</label>
                                    <p>{{ $req->shop_name }}</p>
                                </div>
                                <div class="detail-field">
                                    <label>WhatsApp</label>
                                    <p>
                                        <a href="https://wa.me/{{ $req->whatsapp_number }}" target="_blank"
                                           style="color:#25d366;text-decoration:none;font-weight:600">
                                            <i class="bi bi-whatsapp me-1"></i>{{ $req->whatsapp_number }}
                                        </a>
                                    </p>
                                </div>
                                <div class="detail-field" style="grid-column:span 2">
                                    <label>Alamat Toko</label>
                                    <div class="detail-text-box">{{ $req->shop_address }}</div>
                                </div>
                                <div class="detail-field" style="grid-column:span 2">
                                    <label>Deskripsi Toko</label>
                                    <div class="detail-text-box">{{ $req->shop_description }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <div class="detail-section-title"><i class="bi bi-person-badge"></i> Foto KTP</div>
                            @if($req->ktp_image)
                                <div class="mt-2 text-center">
                                    <a href="{{ asset('storage/ktp/' . $req->ktp_image) }}" target="_blank">
                                        <img src="{{ asset('storage/ktp/' . $req->ktp_image) }}" alt="Foto KTP {{ $req->user->name }}" class="img-fluid rounded border" style="max-height: 250px; object-fit: contain;">
                                    </a>
                                    <div class="mt-2 text-muted" style="font-size: 0.8rem;">
                                        <i class="bi bi-zoom-in"></i> Klik gambar untuk memperbesar
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    <i class="bi bi-exclamation-triangle"></i> Seller ini tidak mengunggah Foto KTP.
                                </div>
                            @endif
                        </div>

                        @if($req->admin_note)
                        <div class="detail-section" style="margin-bottom:0">
                            <div class="detail-section-title"><i class="bi bi-chat-text"></i> Catatan Admin</div>
                            <div class="note-box">
                                <i class="bi bi-chat-quote-fill" style="flex-shrink:0;margin-top:0.1rem"></i>
                                {{ $req->admin_note }}
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if($req->status == 'pending')
                            <button type="button" class="btn-modal-confirm success"
                                    data-bs-dismiss="modal"
                                    onclick="setTimeout(() => document.getElementById('approveTrigger{{ $req->id }}').click(), 300)">
                                <i class="bi bi-check-lg"></i> Setujui
                            </button>
                            <button type="button" class="btn-modal-confirm danger"
                                    data-bs-dismiss="modal"
                                    onclick="setTimeout(() => document.getElementById('rejectTrigger{{ $req->id }}').click(), 300)">
                                <i class="bi bi-x-lg"></i> Tolak
                            </button>
                        @endif
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── APPROVE MODAL ── --}}
        <button id="approveTrigger{{ $req->id }}" class="d-none" type="button"
                data-bs-toggle="modal" data-bs-target="#approveModal{{ $req->id }}"></button>

        <div class="modal fade" id="approveModal{{ $req->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.seller-requests.approve', $req->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="bi bi-check-circle me-2" style="color:#38a169"></i>Setujui Permohonan
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="applicant-card" style="margin-bottom:1rem">
                                <div class="av" style="width:44px;height:44px;border-radius:11px;font-size:1.1rem">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700;color:var(--navy)">{{ $req->user->name }}</div>
                                    <div style="font-size:0.8rem;color:var(--muted)">Toko: {{ $req->shop_name }}</div>
                                </div>
                            </div>
                            <div style="background:#f0fff4;border:1.5px solid #c6f6d5;border-radius:10px;padding:0.85rem 1rem;display:flex;gap:0.6rem;align-items:flex-start;margin-bottom:1rem">
                                <i class="bi bi-info-circle-fill" style="color:#38a169;flex-shrink:0;margin-top:0.1rem"></i>
                                <span style="font-size:0.82rem;color:#276749;line-height:1.5">
                                    User akan otomatis berganti role menjadi <strong>Seller</strong> setelah disetujui.
                                </span>
                            </div>
                            <label style="font-size:0.78rem;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;color:var(--muted);display:block;margin-bottom:0.5rem">
                                Catatan untuk Seller <span style="color:var(--muted);font-weight:400">(Opsional)</span>
                            </label>
                            <textarea name="note" class="textarea-styled" rows="3"
                                      placeholder="Pesan selamat atau instruksi untuk seller baru..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-modal-confirm success">
                                <i class="bi bi-check-lg me-1"></i> Konfirmasi Setujui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── REJECT MODAL ── --}}
        <button id="rejectTrigger{{ $req->id }}" class="d-none" type="button"
                data-bs-toggle="modal" data-bs-target="#rejectModal{{ $req->id }}"></button>

        <div class="modal fade" id="rejectModal{{ $req->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.seller-requests.reject', $req->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="bi bi-x-circle me-2" style="color:#e53e3e"></i>Tolak Permohonan
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="applicant-card" style="margin-bottom:1rem">
                                <div class="av" style="width:44px;height:44px;border-radius:11px;font-size:1.1rem">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700;color:var(--navy)">{{ $req->user->name }}</div>
                                    <div style="font-size:0.8rem;color:var(--muted)">Toko: {{ $req->shop_name }}</div>
                                </div>
                            </div>
                            <label style="font-size:0.78rem;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;color:var(--muted);display:block;margin-bottom:0.5rem">
                                Alasan Penolakan <span style="color:#e53e3e">*</span>
                            </label>
                            <textarea name="note" class="textarea-styled" rows="4"
                                      placeholder="Contoh: Nama toko tidak sesuai, deskripsi tidak jelas..."
                                      required></textarea>
                            <p style="font-size:0.78rem;color:var(--muted);margin-top:0.5rem;margin-bottom:0">
                                <i class="bi bi-info-circle me-1"></i> Alasan ini akan dikirim ke pemohon sebagai notifikasi.
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
    @endforeach


    <div class="pagination-wrap">
        <span class="pagination-info">
            Menampilkan {{ $requests->firstItem() }}–{{ $requests->lastItem() }} dari {{ $requests->total() }} request
        </span>
        {{ $requests->withQueryString()->links() }}
    </div>
</div>

@endsection