@extends('layouts.app')

@section('title', 'Keranjang Belanja - Preloved Market')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-navy mb-4">
                <i class="bi bi-cart"></i> Keranjang Belanja
            </h2>
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
        @if($cartItems->count() > 0)
            <div class="col-lg-8">
                {{-- Daftar Produk di Keranjang --}}
                @foreach($cartItems as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-4">
                                <img src="{{ asset('storage/products/' . $item->product->image) }}" 
                                     class="img-fluid rounded" alt="{{ $item->product->name }}">
                            </div>
                            <div class="col-md-5 col-8">
                                <h6>{{ $item->product->name }}</h6>
                                <p class="text-muted mb-1">
                                    <small>Penjual: {{ $item->product->user->name }}</small>
                                </p>
                                <p class="text-navy fw-bold mb-0">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="col-md-3 col-6 mt-3 mt-md-0">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                           min="1" class="form-control form-control-sm me-2" style="width: 70px">
                                    <button type="submit" class="btn btn-sm btn-outline-navy">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-2 col-6 mt-3 mt-md-0 text-end">
                                <p class="fw-bold mb-2">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </p>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="col-lg-4">
                {{-- Ringkasan Belanja --}}
                <div class="card">
                    <div class="card-header bg-navy text-white">
                        <h5 class="mb-0">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td>Total Harga ({{ $cartItems->count() }} barang)</td>
                                <td class="text-end">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Ongkos Kirim</td>
                                <td class="text-end">Rp 0</td>
                            </tr>
                            <tr class="fw-bold">
                                <td>Total</td>
                                <td class="text-end text-navy">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        
                        <a href="{{ route('checkout.index') }}" class="btn btn-navy w-100">
                            <i class="bi bi-cart-check"></i> Checkout
                        </a>
                        
                        <a href="{{ route('products.index') }}" class="btn btn-outline-navy w-100 mt-2">
                            <i class="bi bi-arrow-left"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-cart-x fs-1 text-muted"></i>
                        <h5 class="mt-3">Keranjang Belanja Kosong</h5>
                        <p class="text-muted">Anda belum menambahkan produk apapun ke keranjang.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-navy">
                            <i class="bi bi-shop"></i> Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection