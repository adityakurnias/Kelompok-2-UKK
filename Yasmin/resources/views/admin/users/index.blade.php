@extends('layouts.admin')

@section('title', 'Kelola Users - Admin')
@section('page-title', 'Kelola Users')

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
        transition: all 0.2s;
        cursor: pointer;
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
    .stat-chip.active-buyer  { border-color: #2b6cb0; background: #ebf4ff; color: #2b6cb0; }
    .stat-chip.active-seller { border-color: #276749; background: #f0fff4; color: #276749; }
    .stat-chip.active-admin  { border-color: #9b2c2c; background: #fff5f5; color: #9b2c2c; }

    .stat-chip .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .dot-all    { background: var(--navy); }
    .dot-buyer  { background: #4299e1; }
    .dot-seller { background: #48bb78; }
    .dot-admin  { background: #e53e3e; }

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

    .count-badge {
        background: var(--soft);
        color: var(--muted);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
    }

    /* ── TABLE ── */
    .users-table { width: 100%; border-collapse: collapse; }

    .users-table thead th {
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

    .users-table thead th:first-child { padding-left: 1.5rem; }
    .users-table thead th:last-child  { padding-right: 1.5rem; }

    .users-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .users-table tbody tr:last-child { border-bottom: none; }
    .users-table tbody tr:hover { background: #fafaf9; }

    .users-table tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        font-size: 0.875rem;
        color: var(--ink);
    }

    .users-table tbody td:first-child { padding-left: 1.5rem; }
    .users-table tbody td:last-child  { padding-right: 1.5rem; }

    /* User cell */
    .user-cell { display: flex; align-items: center; gap: 0.75rem; }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        object-fit: cover;
        background: var(--soft);
        border: 1.5px solid var(--border);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--navy);
        font-size: 1.1rem;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 9px;
    }

    .user-name { font-weight: 600; font-size: 0.875rem; color: var(--navy); margin-bottom: 0.1rem; }
    .user-joined { font-size: 0.75rem; color: var(--muted); }

    /* Role badge */
    .badge-role {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.28rem 0.7rem;
        border-radius: 20px;
        font-size: 0.73rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-role .dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge-role.admin  { background: #fff5f5; color: #9b2c2c; }
    .badge-role.admin .dot  { background: #e53e3e; }
    .badge-role.seller { background: #f0fff4; color: #276749; }
    .badge-role.seller .dot { background: #48bb78; }
    .badge-role.buyer  { background: #ebf4ff; color: #2b6cb0; }
    .badge-role.buyer .dot  { background: #4299e1; }

    /* Status badge */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.28rem 0.7rem;
        border-radius: 20px;
        font-size: 0.73rem;
        font-weight: 600;
    }

    .badge-status .dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge-status.active   { background: #f0fff4; color: #276749; }
    .badge-status.active .dot   { background: #48bb78; }
    .badge-status.blocked  { background: #fff5f5; color: #9b2c2c; }
    .badge-status.blocked .dot  { background: #e53e3e; }

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
        flex-shrink: 0;
    }

    .btn-action:hover { transform: translateY(-1px); }
    .btn-action.view:hover   { border-color: #4299e1; color: #2b6cb0; background: #ebf4ff; }
    .btn-action.block:hover  { border-color: #ecc94b; color: #744210; background: #fffff0; }
    .btn-action.unblock:hover{ border-color: #48bb78; color: #276749; background: #f0fff4; }
    .btn-action.delete:hover { border-color: #e53e3e; color: #9b2c2c; background: #fff5f5; }

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

    .modal-body { padding: 1.5rem; }
    .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); gap: 0.5rem; }

    /* Detail user card */
    .detail-user-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: var(--soft);
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        margin-bottom: 1.25rem;
    }

    .detail-avatar {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--navy);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        font-size: 1.5rem;
        flex-shrink: 0;
        overflow: hidden;
    }

    .detail-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .detail-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
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

    .detail-field p { font-size: 0.875rem; color: var(--ink); font-weight: 500; margin: 0; }

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
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-modal-confirm:hover { background: var(--navy-mid); color: white; }
    .btn-modal-confirm.danger { background: #e53e3e; }
    .btn-modal-confirm.warning { background: #d69e2e; }

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

    /* Stats mini in detail */
    .detail-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .detail-stat-box {
        background: var(--soft);
        border-radius: 10px;
        padding: 0.75rem;
        text-align: center;
    }

    .detail-stat-box .val {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1;
        margin-bottom: 0.2rem;
    }

    .detail-stat-box .lbl { font-size: 0.72rem; color: var(--muted); font-weight: 600; }

    /* ── ADD USER MODAL ── */
    .add-user-modal .form-group {
        margin-bottom: 1rem;
    }
    
    .add-user-modal label {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--muted);
        display: block;
        margin-bottom: 0.35rem;
    }
    
    .add-user-modal .required-star {
        color: #e53e3e;
        margin-left: 2px;
    }
    
    .add-user-modal .form-control,
    .add-user-modal .form-select {
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 0.6rem 1rem;
        font-size: 0.875rem;
        width: 100%;
        transition: all 0.2s;
    }
    
    .add-user-modal .form-control:focus,
    .add-user-modal .form-select:focus {
        border-color: var(--navy);
        outline: none;
        box-shadow: 0 0 0 3px rgba(15,36,68,0.08);
    }
    
    /* ── MOBILE CARD LIST ── */
    .user-mobile-list { display: none; }
    .user-card-mob {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin: 1rem;
    }
    .user-card-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
    .user-card-body { font-size: 0.85rem; }
    .user-card-field { display: flex; justify-content: space-between; margin-bottom: 0.4rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.3rem; }
    .user-card-field:last-child { border-bottom: none; }
    .user-card-label { color: var(--muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; }

    @media (max-width: 991px) {
        .users-table-container { display: none; }
        .user-mobile-list { display: block; }
        .filter-bar { padding: 1rem; }
        .stats-row { padding: 0 0.5rem; justify-content: center; }
        .table-card-header { flex-direction: column; align-items: stretch; }
        .btn-filter { width: 100%; justify-content: center; }
    }

    @media (max-width: 767px) {
        .filter-group { min-width: 100%; }
        .filter-group.search-group { min-width: 100%; flex: auto; }
        .filter-actions { width: 100%; }
        .filter-actions .btn-filter,
        .filter-actions .btn-filter-ghost { flex: 1; justify-content: center; }
        .stats-row { gap: 0.5rem; }
        .stat-chip { font-size: 0.78rem; padding: 0.5rem 0.85rem; }
        .user-card-mob { margin: 0.75rem; padding: 0.85rem; }
        .detail-info-grid { grid-template-columns: 1fr; }
        .detail-info-grid .detail-field[style*="span 2"] { grid-column: span 1; }
        .detail-user-card { flex-direction: column; text-align: center; gap: 0.75rem; }
        .detail-stats { grid-template-columns: 1fr 1fr 1fr; gap: 0.5rem; }
    }

    @media (max-width: 575px) {
        .stats-row { justify-content: flex-start; }
        .stat-chip { font-size: 0.75rem; padding: 0.45rem 0.75rem; gap: 0.4rem; }
        .user-card-mob { margin: 0.5rem; }
        .user-card-header .user-name { font-size: 0.82rem; }
        .detail-stats { grid-template-columns: 1fr; }
        .detail-stat-box .val { font-size: 1.2rem; }
        .detail-stat-box .lbl { font-size: 0.68rem; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Kelola Users</h1>
    <p>Lihat, blokir, tambah, dan kelola semua pengguna terdaftar.</p>
</div>

{{-- Success Alert --}}
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center mb-4" role="alert" style="border-radius:12px">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

{{-- ── STATS ROW ── --}}
@php
    $allCount    = \App\Models\User::count();
    $buyerCount  = \App\Models\User::where('role','buyer')->count();
    $sellerCount = \App\Models\User::where('role','seller')->count();
    $adminCount  = \App\Models\User::where('role','admin')->count();
    $currentRole = request('role', '');
@endphp

<div class="stats-row">
    <a href="{{ route('admin.users') }}" class="stat-chip {{ $currentRole == '' ? 'active-all' : '' }}">
        <span class="dot dot-all"></span> Semua <strong>{{ $allCount }}</strong>
    </a>
    <a href="{{ route('admin.users', ['role' => 'buyer']) }}" class="stat-chip {{ $currentRole == 'buyer' ? 'active-buyer' : '' }}">
        <span class="dot dot-buyer"></span> Buyer <strong>{{ $buyerCount }}</strong>
    </a>
    <a href="{{ route('admin.users', ['role' => 'seller']) }}" class="stat-chip {{ $currentRole == 'seller' ? 'active-seller' : '' }}">
        <span class="dot dot-seller"></span> Seller <strong>{{ $sellerCount }}</strong>
    </a>
    <a href="{{ route('admin.users', ['role' => 'admin']) }}" class="stat-chip {{ $currentRole == 'admin' ? 'active-admin' : '' }}">
        <span class="dot dot-admin"></span> Admin <strong>{{ $adminCount }}</strong>
    </a>
</div>

{{-- ── FILTER BAR ── --}}
<div class="filter-bar">
    <form action="{{ route('admin.users') }}" method="GET"
          style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:flex-end;width:100%">

        <div class="filter-group search-group">
            <label>Cari User</label>
            <div style="position:relative">
                <i class="bi bi-search" style="position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:0.85rem"></i>
                <input type="text" name="search" class="form-control" style="padding-left:2.4rem"
                       placeholder="Nama atau email..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="filter-group">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="">Semua Role</option>
                <option value="buyer"  {{ request('role') == 'buyer'  ? 'selected' : '' }}>Buyer</option>
                <option value="seller" {{ request('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                <option value="admin"  {{ request('role') == 'admin'  ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="active"  {{ request('status') == 'active'  ? 'selected' : '' }}>Aktif</option>
                <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Diblokir</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-filter"><i class="bi bi-funnel"></i> Filter</button>
            <a href="{{ route('admin.users') }}" class="btn-filter-ghost"><i class="bi bi-x-lg"></i> Reset</a>
        </div>
    </form>
</div>

{{-- ── TABLE ── --}}
<div class="table-card">
    <div class="table-card-header">
        <h6>
            <i class="bi bi-people"></i> Daftar Users
            <span class="count-badge">{{ $users->total() }} user</span>
        </h6>
        <button class="btn-filter" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-lg"></i> Tambah User Baru
        </button>
    </div>

    <div class="users-table-container">
        <table class="users-table" style="width:100%; overflow-x:auto;">
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                    <th style="width:120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td>{{ $users->firstItem() + $index }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar">
                                @if($user->photo)
                                    <img src="{{ asset('storage/users/' . $user->photo) }}">
                                @else
                                    <i class="bi bi-person-fill"></i>
                                @endif
                            </div>
                            <div>
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-joined">ID #{{ $user->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '—' }}</td>
                    <td>
                        <span class="badge-role {{ $user->role }}">
                            <span class="dot"></span> {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        @if(isset($user->is_blocked) && $user->is_blocked)
                            <span class="badge-status blocked"><span class="dot"></span> Diblokir</span>
                        @else
                            <span class="badge-status active"><span class="dot"></span> Aktif</span>
                        @endif
                    </td>
                    <td><span style="font-size:0.8rem;color:var(--muted)">{{ $user->created_at->format('d/m/y') }}</span></td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action view" type="button" data-bs-toggle="modal" data-bs-target="#detailModal{{ $user->id }}" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            @if($user->role != 'admin')
                                @if(isset($user->is_blocked) && $user->is_blocked)
                                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="action" value="unblock">
                                        <button class="btn-action unblock" type="submit" title="Buka Blokir">
                                            <i class="bi bi-shield-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn-action block" type="button" data-bs-toggle="modal" data-bs-target="#blockModal{{ $user->id }}" title="Blokir User">
                                        <i class="bi bi-shield-lock"></i>
                                    </button>
                                @endif
                                <button class="btn-action delete" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}" title="Hapus User">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <p>Tidak ada user ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile List --}}
    <div class="user-mobile-list">
        @forelse($users as $index => $user)
            <div class="user-card-mob">
                <div class="user-card-header">
                    <div class="user-avatar">
                        @if($user->photo)
                            <img src="{{ asset('storage/users/' . $user->photo) }}">
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif
                    </div>
                    <div>
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-joined">ID #{{ $user->id }}</div>
                    </div>
                    <div class="ms-auto">
                         <span class="badge-role {{ $user->role }} small">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
                <div class="user-card-body">
                    <div class="user-card-field">
                        <span class="user-card-label">Email</span>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="user-card-field">
                        <span class="user-card-label">Status</span>
                        @if(isset($user->is_blocked) && $user->is_blocked)
                            <span class="text-danger fw-bold">Diblokir</span>
                        @else
                            <span class="text-success fw-bold">Aktif</span>
                        @endif
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-sm btn-outline-navy flex-grow-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $user->id }}">
                            <i class="bi bi-eye"></i> Detail
                        </button>
                        @if($user->role != 'admin')
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <p>Tidak ada user ditemukan</p>
            </div>
        @endforelse
    </div>

    {{-- Modals Loop --}}
    @foreach($users as $user)
        {{-- Detail Modal --}}
        <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="detail-user-card">
                            <div class="detail-avatar">
                                @if($user->photo) <img src="{{ asset('storage/users/' . $user->photo) }}"> @else <i class="bi bi-person-fill"></i> @endif
                            </div>
                            <div>
                                <div class="h5 mb-1">{{ $user->name }}</div>
                                <span class="badge-role {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                        <div class="detail-info-grid">
                            <div class="detail-field"><label>Email</label><p>{{ $user->email }}</p></div>
                            <div class="detail-field"><label>Phone</label><p>{{ $user->phone ?? '—' }}</p></div>
                            <div class="detail-field" style="grid-column: span 2"><label>Alamat</label><p>{{ $user->address ?? '—' }}</p></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <button id="blockTrigger{{ $user->id }}" class="d-none" type="button" data-bs-toggle="modal" data-bs-target="#blockModal{{ $user->id }}"></button>
        <div class="modal fade" id="blockModal{{ $user->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="action" value="block">
                        <div class="modal-header"><h5 class="modal-title">Blokir User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            <label class="mb-2">Alasan Blokir *</label>
                            <textarea name="reason" class="textarea-styled" rows="3" required placeholder="Berikan alasan..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-modal-confirm warning">Blokir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <button id="deleteTrigger{{ $user->id }}" class="d-none" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}"></button>
        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <div class="modal-header"><h5 class="modal-title">Hapus User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body"><p>Apakah Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>? Data produk dan pesanan terkait akan ikut terhapus.</p></div>
                        <div class="modal-footer"><button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-modal-confirm danger">Ya, Hapus</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <div class="pagination-wrap">
        <span class="pagination-info">Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user</span>
        {{ $users->withQueryString()->links() }}
    </div>
</div>

{{-- MODAL TAMBAH USER --}}
<div class="modal fade add-user-modal" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Tambah User Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12"><label>Nama Lengkap *</label><input type="text" name="name" class="form-control" required></div>
                        <div class="col-12"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
                        <div class="col-6"><label>Password *</label><input type="password" name="password" class="form-control" required></div>
                        <div class="col-6"><label>Konfirmasi Password *</label><input type="password" name="password_confirmation" class="form-control" required></div>
                        <div class="col-6"><label>Role *</label><select name="role" class="form-select"><option value="buyer">Buyer</option><option value="seller">Seller</option><option value="admin">Admin</option></select></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-confirm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection