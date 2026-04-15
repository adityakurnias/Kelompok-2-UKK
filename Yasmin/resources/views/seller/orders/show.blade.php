@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $orderItem->order->order_number . ' - Seller')

@push('styles')
<style>
    .order-detail-container {
        padding: 2rem 0 4rem;
        background: var(--soft);
        min-height: 85vh;
    }
    .detail-card {
        background: white;
        border-radius: 20px;
        border: 1.5px solid var(--border);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(15,36,68,0.05);
    }
    .detail-header {
        background: var(--navy);
        color: white;
        padding: 2rem;
    }
    .detail-body {
        padding: 2.5rem;
    }
    .info-section {
        margin-bottom: 2.5rem;
    }
    .info-title {
        font-family: 'DM Sans', sans-serif;
        font-weight: 700;
        color: var(--navy);
        font-size: 1.1rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-bottom: 2px solid var(--soft);
        padding-bottom: 0.75rem;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    .info-label {
        color: #64748b;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .info-value {
        color: var(--navy);
        font-weight: 500;
    }
    .product-box {
        display: flex;
        gap: 1.5rem;
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 16px;
        align-items: center;
    }
    .product-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 12px;
    }
    .payment-proof-box {
        border: 2px dashed var(--border);
        border-radius: 16px;
        padding: 1rem;
        text-align: center;
        margin-top: 1rem;
    }
    .payment-proof-img {
        max-width: 100%;
        max-height: 400px;
        border-radius: 10px;
        cursor: pointer;
        transition: transform 0.3s;
    }
    .payment-proof-img:hover {
        transform: scale(1.02);
    }
    .status-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
    }
</style>
@endpush

@section('content')
<div class="order-detail-container">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('seller.orders') }}" class="text-decoration-none text-navy fw-bold">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
            </a>
        </div>

        <div class="detail-card">
            <div class="detail-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <small class="text-white-50 text-uppercase letter-spacing-1">Nomor Pesanan</small>
                        <h2 class="mb-0 fw-bold">{{ $orderItem->order->order_number }}</h2>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        @php
                            $statusSlug = $orderItem->order->status;
                            $statusClass = [
                                'pending' => 'bg-warning text-dark',
                                'confirmed' => 'bg-info text-white',
                                'shipped' => 'bg-primary text-white',
                                'completed' => 'bg-success text-white',
                                'cancelled' => 'bg-danger text-white'
                            ][$statusSlug] ?? 'bg-secondary text-white';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ ucfirst($statusSlug) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="detail-body">
                <div class="row">
                    <div class="col-lg-7">
                        {{-- Product Info --}}
                        <div class="info-section">
                            <h4 class="info-title"><i class="bi bi-box-seam"></i> Produk yang Dipesan</h4>
                            <div class="product-box">
                                <img src="{{ asset('storage/products/' . $orderItem->product->image) }}" alt="{{ $orderItem->product->name }}" class="product-img">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $orderItem->product->name }}</h5>
                                    <p class="text-muted small mb-2">Harga Satuan: Rp {{ number_format($orderItem->price, 0, ',', '.') }}</p>
                                    <div class="d-flex align-items-center gap-4">
                                        <div>
                                            <span class="info-label d-block">Jumlah</span>
                                            <span class="badge bg-navy text-white fs-6 px-3">{{ $orderItem->quantity }}</span>
                                        </div>
                                        <div>
                                            <span class="info-label d-block">Subtotal</span>
                                            <span class="fw-bold text-navy fs-5">Rp {{ number_format($orderItem->subtotal, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Buyer Info --}}
                        <div class="info-section">
                            <h4 class="info-title"><i class="bi bi-person"></i> Informasi Pembeli</h4>
                            <div class="info-grid">
                                <div>
                                    <label class="info-label">Nama Pembeli</label>
                                    <div class="info-value">{{ $orderItem->order->buyer->name }}</div>
                                </div>
                                <div>
                                    <label class="info-label">Email</label>
                                    <div class="info-value">{{ $orderItem->order->buyer->email }}</div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="info-label">Alamat Pengiriman</label>
                                    <div class="info-value p-3 bg-light rounded-3 mt-1">
                                        {{ $orderItem->order->shipping_address }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        {{-- Payment Info --}}
                        <div class="info-section">
                            <h4 class="info-title"><i class="bi bi-credit-card"></i> Pembayaran</h4>
                            <div class="mb-3">
                                <label class="info-label">Metode Pembayaran</label>
                                <div class="info-value">
                                    {{ $orderItem->order->payment_method == 'transfer_bank' ? 'Transfer Bank' : 'COD' }}
                                </div>
                            </div>

                            @if($orderItem->order->payment_method == 'transfer_bank')
                            <div>
                                <label class="info-label">Bukti Pembayaran</label>
                                @if($orderItem->order->payment_proof)
                                <div class="payment-proof-box">
                                    <img src="{{ asset('storage/payments/' . $orderItem->order->payment_proof) }}" 
                                         alt="Bukti Pembayaran" class="payment-proof-img"
                                         data-bs-toggle="modal" data-bs-target="#imageModal">
                                    <p class="mt-2 mb-0 small text-muted"><i class="bi bi-zoom-in"></i> Klik untuk memperbesar</p>
                                </div>
                                @else
                                <div class="alert alert-warning py-2 small">
                                    <i class="bi bi-exclamation-triangle"></i> Bukti pembayaran belum diunggah.
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>

                        {{-- Order Actions --}}
                        @if($orderItem->order->status == 'pending' || $orderItem->order->status == 'confirmed')
                        <div class="info-section mb-0">
                            <h4 class="info-title"><i class="bi bi-gear"></i> Aksi Pesanan</h4>
                            <div class="d-grid gap-2">
                                @if($orderItem->order->status == 'pending')
                                    <form action="{{ route('seller.orders.confirm', $orderItem->order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-navy w-100 py-2 fw-bold">
                                            <i class="bi bi-check-circle me-2"></i> Konfirmasi Pesanan
                                        </button>
                                    </form>
                                @endif
                                
                                @if($orderItem->order->status == 'confirmed')
                                    <button class="btn btn-navy w-100 py-2 fw-bold" data-bs-toggle="modal" 
                                            data-bs-target="#shipModal">
                                        <i class="bi bi-truck me-2"></i> Update Pengiriman & Resi
                                    </button>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Image Zoom Modal --}}
@if($orderItem->order->payment_proof)
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body p-0 text-center">
                <img src="{{ asset('storage/payments/' . $orderItem->order->payment_proof) }}" class="img-fluid rounded shadow">
                <button type="button" class="btn btn-light mt-3 px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Ship Modal --}}
@if($orderItem->order->status == 'confirmed')
<div class="modal fade" id="shipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-modern" style="border-radius: 20px;">
            <form action="{{ route('seller.orders.ship', $orderItem->order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-navy text-white p-4">
                    <h5 class="modal-title fw-bold">Update Pengiriman</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-600">Jasa Kurir</label>
                        <input type="text" name="courier" class="form-control" placeholder="Contoh: JNE, J&T..." required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-600">Nomor Resi</label>
                        <input type="text" name="tracking_number" class="form-control" placeholder="Masukkan nomor resi" required>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-navy px-4">Update Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
