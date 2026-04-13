@extends('layouts.app')

@section('title', 'Pesanan Saya - Preloved Market')

@push('styles')
<style>
    .orders-container {
        padding: 2rem 0;
        background-color: var(--soft);
        min-height: 80vh;
    }

    .orders-tabs {
        border-bottom: 2px solid var(--border);
        margin-bottom: 2rem;
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .orders-tabs .nav-link {
        border: none;
        background: none;
        padding: 0.75rem 0.5rem;
        color: var(--muted);
        font-weight: 600;
        font-size: 0.95rem;
        position: relative;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .orders-tabs .nav-link:hover {
        color: var(--navy);
    }

    .orders-tabs .nav-link.active {
        color: var(--navy);
    }

    .orders-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--navy);
    }

    .orders-card-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
</style>
@endpush

@section('content')
<div class="orders-container">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-navy fw-bold mb-2" style="font-size: 2rem;">
                    <i class="bi bi-box me-2"></i> Pesanan Saya
                </h2>
                <p class="text-muted mb-0">Pantau status dan detail pesanan belanjamu di satu tempat.</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="nav orders-tabs" id="orderTabs" role="tablist">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">Semua</button>
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">Menunggu</button>
                <button class="nav-link" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirmed" type="button">Proses</button>
                <button class="nav-link" id="shipped-tab" data-bs-toggle="tab" data-bs-target="#shipped" type="button">Dikirim</button>
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button">Selesai</button>
            </div>
            
            <div class="tab-content" id="orderTabsContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                    @include('buyer.orders.partials.order-list', ['orders' => $orders])
                </div>
                <div class="tab-pane fade" id="pending" role="tabpanel">
                    @include('buyer.orders.partials.order-list', ['orders' => $orders->where('status', 'pending')])
                </div>
                <div class="tab-pane fade" id="confirmed" role="tabpanel">
                    @include('buyer.orders.partials.order-list', ['orders' => $orders->where('status', 'confirmed')])
                </div>
                <div class="tab-pane fade" id="shipped" role="tabpanel">
                    @include('buyer.orders.partials.order-list', ['orders' => $orders->where('status', 'shipped')])
                </div>
                <div class="tab-pane fade" id="completed" role="tabpanel">
                    @include('buyer.orders.partials.order-list', ['orders' => $orders->where('status', 'completed')])
                </div>
            </div>
            
                @if($orders->count() > 0)
                <div class="d-flex justify-content-center mt-5 pb-5">
                    {{ $orders->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection