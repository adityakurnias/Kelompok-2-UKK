@extends('layouts.app')

@section('title', 'Pesanan Saya - Preloved Market')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-navy mb-4">
                <i class="bi bi-box"></i> Pesanan Saya
            </h2>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="orderTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">
                                Semua
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                                Pending
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirmed" type="button">
                                Dikonfirmasi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipped-tab" data-bs-toggle="tab" data-bs-target="#shipped" type="button">
                                Dikirim
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button">
                                Selesai
                            </button>
                        </li>
                    </ul>
                    
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
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection