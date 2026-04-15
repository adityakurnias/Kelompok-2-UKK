@extends('layouts.app')

@section('title', 'Pesanan Masuk - Seller')

@push('styles')
<style>
    .seller-orders-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(15,36,68,0.03);
    }

    .orders-table {
        width: 100%;
        margin-bottom: 0;
    }

    .orders-table thead th {
        background: #f8fafc;
        color: var(--navy);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1.25rem 1.5rem;
        border-bottom: 1.5px solid var(--border);
    }

    .orders-table tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        color: var(--ink);
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }

    .orders-table tbody tr:hover {
        background-color: #fbfcfd;
    }

    /* Modern Badges */
    .badge-pill {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 0.02em;
    }

    .badge-soft-pending { background: #fffbeb; color: #d97706; }
    .badge-soft-confirmed { background: #ecfeff; color: #0891b2; }
    .badge-soft-shipped { background: #eff6ff; color: #2563eb; }
    .badge-soft-completed { background: #f0fdf4; color: #16a34a; }
    .badge-soft-cancelled { background: #fef2f2; color: #dc2626; }

    .btn-action-sm {
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-action-sm:hover {
        background: #1a3a5f;
        transform: translateY(-2px);
    }

    /* Modal Styling */
    .modal-content-modern {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(15,36,68,0.15);
    }

    .modal-header-navy {
        background: var(--navy);
        color: white;
        padding: 1.5rem;
        border: none;
    }

    .modal-body-clean {
        padding: 2rem;
    }

    .form-control-modern {
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-control-modern:focus {
        border-color: var(--navy);
        box-shadow: 0 0 0 4px rgba(15,36,68,0.05);
    }

    .modal-footer-clean {
        padding: 1.25rem 2rem;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
    }

    .order-num-text {
        font-family: 'DM Sans', sans-serif;
        font-weight: 700;
        color: var(--navy);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-navy mb-4"><i class="bi bi-cart-check"></i> Pesanan Masuk</h2>
            
            
            <div class="seller-orders-card">
                <div class="table-responsive">
                    <table class="table orders-table">
                        <thead>
                            <tr>
                                <th>No. Order</th>
                                <th>Pembeli</th>
                                <th>Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orderItems as $item)
                            <tr>
                                <td>
                                    <span class="order-num-text">{{ $item->order->order_number }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $item->order->buyer->name }}</div>
                                    <small class="text-muted">{{ $item->order->buyer->email }}</small>
                                </td>
                                <td>
                                    <div class="text-navy fw-bold">{{ $item->product->name }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-navy text-white fw-bold px-3 py-2">{{ $item->quantity }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $statusSlug = $item->order->status;
                                        $statusLabel = [
                                            'pending' => 'Pending',
                                            'confirmed' => 'Dikonfirmasi',
                                            'shipped' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan'
                                        ][$statusSlug] ?? ucfirst($statusSlug);
                                    @endphp
                                    <span class="badge badge-pill badge-soft-{{ $statusSlug }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('seller.orders.show', $item->id) }}" class="btn btn-outline-navy btn-action-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        @if($item->order->status == 'pending')
                                            <form action="{{ route('seller.orders.confirm', $item->order) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-navy btn-action-sm">
                                                    <i class="bi bi-check-circle"></i> Konfirmasi
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($item->order->status == 'confirmed')
                                            <button class="btn btn-navy btn-action-sm" data-bs-toggle="modal" 
                                                    data-bs-target="#shipModal{{ $item->order->id }}">
                                                <i class="bi bi-truck"></i> Kirim
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            
                            {{-- Ship Modal --}}
                            <div class="modal fade" id="shipModal{{ $item->order->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-content-modern">
                                        <form action="{{ route('seller.orders.ship', $item->order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header modal-header-navy">
                                                <h5 class="modal-title fw-bold">
                                                    <i class="bi bi-truck me-2"></i> Update Pengiriman
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body modal-body-clean">
                                                <p class="text-muted small mb-4">
                                                    Silakan masukkan detail kurir dan nomor resi untuk pesanan <b>#{{ $item->order->order_number }}</b>.
                                                </p>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-600">
                                                        <i class="bi bi-box-seam me-1 text-navy"></i> Jasa Kurir
                                                    </label>
                                                    <input type="text" name="courier" class="form-control form-control-modern" 
                                                           placeholder="Contoh: JNE, J&T, Sicepat..." required>
                                                </div>
                                                
                                                <div class="mb-0">
                                                    <label class="form-label fw-600">
                                                        <i class="bi bi-hash me-1 text-navy"></i> Nomor Resi
                                                    </label>
                                                    <input type="text" name="tracking_number" class="form-control form-control-modern" 
                                                           placeholder="Masukkan nomor resi pengiriman" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer modal-footer-clean">
                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                                                <button type="submit" class="btn btn-navy px-4" style="border-radius:10px;">
                                                    <i class="bi bi-send me-2"></i> Update Pengiriman
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="mt-2">Belum ada pesanan masuk</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 d-flex justify-content-center">
                    {{ $orderItems->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection