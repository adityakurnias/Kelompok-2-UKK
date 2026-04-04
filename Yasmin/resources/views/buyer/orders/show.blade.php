@extends('layouts.app')

@section('title', 'Detail Pesanan - Preloved Market')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                    <li class="breadcrumb-item active">Detail Pesanan</li>
                </ol>
            </nav>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-lg-8">
            {{-- Status Timeline --}}
            <div class="card mb-4">
                <div class="card-header bg-navy text-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Status Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        @php
                            $steps = [
                                'pending' => ['label' => 'Pending', 'icon' => 'bi-clock', 'color' => 'warning'],
                                'confirmed' => ['label' => 'Dikonfirmasi', 'icon' => 'bi-check-circle', 'color' => 'info'],
                                'shipped' => ['label' => 'Dikirim', 'icon' => 'bi-truck', 'color' => 'primary'],
                                'completed' => ['label' => 'Selesai', 'icon' => 'bi-star', 'color' => 'success'],
                            ];
                            
                            $currentStep = array_search($order->status, array_keys($steps));
                            if ($order->status == 'cancelled') {
                                $currentStep = -1;
                            }
                        @endphp
                        
                        @foreach($steps as $key => $step)
                            <div class="text-center" style="flex:1">
                                <div class="rounded-circle p-3 d-inline-block mb-2
                                    @if(array_search($key, array_keys($steps)) <= $currentStep && $order->status != 'cancelled')
                                        bg-{{ $step['color'] }} text-white
                                    @else
                                        bg-light text-muted
                                    @endif">
                                    <i class="bi {{ $step['icon'] }} fs-4"></i>
                                </div>
                                <div>
                                    <small class="d-block fw-bold">{{ $step['label'] }}</small>
                                    @if($key == $order->status)
                                        <span class="badge bg-{{ $step['color'] }}">Sekarang</span>
                                    @endif
                                </div>
                            </div>
                            @if(!$loop->last)
                                <div class="text-muted" style="flex:0.5; text-align:center">
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    @if($order->status == 'cancelled')
                        <div class="alert alert-danger">
                            <i class="bi bi-x-octagon"></i> Pesanan ini telah dibatalkan.
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- Daftar Produk --}}
            <div class="card mb-4">
                <div class="card-header bg-navy text-white">
                    <h5 class="mb-0"><i class="bi bi-box"></i> Produk Dipesan</h5>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <img src="{{ asset('storage/products/' . $item->product->image) }}" 
                                 class="img-fluid rounded" alt="{{ $item->product->name }}">
                        </div>
                        <div class="col-md-6">
                            <h6>{{ $item->product->name }}</h6>
                            <p class="text-muted mb-1">Penjual: {{ $item->seller->name }}</p>
                            <p class="text-muted mb-0">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <p class="fw-bold text-navy">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            @if($order->status == 'completed')
                                <a href="{{ route('products.show', $item->product) }}" class="btn btn-sm btn-outline-navy">
                                    <i class="bi bi-cart-plus"></i> Beli Lagi
                                </a>
                            @endif
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            {{-- Ringkasan Pembayaran --}}
            <div class="card mb-4">
                <div class="card-header bg-navy text-white">
                    <h5 class="mb-0"><i class="bi bi-credit-card"></i> Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td>No. Order</td>
                            <td class="text-end"><strong>{{ $order->order_number }}</strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal Order</td>
                            <td class="text-end">{{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Metode Pembayaran</td>
                            <td class="text-end">
                                {{ $order->payment_method == 'transfer_bank' ? 'Transfer Bank' : 'COD' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-end">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Ongkos Kirim</td>
                            <td class="text-end">Rp 0</td>
                        </tr>
                        <tr class="fw-bold">
                            <td>Total</td>
                            <td class="text-end text-navy">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                    
                    @if($order->payment_method == 'transfer_bank')
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle"></i>
                            <strong>Rekening Tujuan:</strong><br>
                            BCA: 1234567890 a.n. Preloved Market
                        </div>
                        
                        @if($order->payment_proof)
                            <a href="{{ asset('storage/payments/' . $order->payment_proof) }}" target="_blank" 
                               class="btn btn-outline-info w-100">
                                <i class="bi bi-eye"></i> Lihat Bukti Transfer
                            </a>
                        @else
                            <div class="alert alert-warning mt-2">
                                <i class="bi bi-exclamation-triangle"></i> Belum upload bukti transfer
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            
            {{-- Informasi Pengiriman --}}
            <div class="card">
                <div class="card-header bg-navy text-white">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p><strong>Alamat Pengiriman:</strong></p>
                    <p class="text-muted">{{ $order->shipping_address }}</p>
                    
                    @if($order->status == 'shipped')
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> Pesanan telah dikirim
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- Tombol Aksi --}}
            <div class="mt-3 d-grid gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-navy">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
