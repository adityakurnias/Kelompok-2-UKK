@extends('layouts.app')

@section('title', 'Daftar Produk - Preloved Market')

@section('content')
<div class="container py-4">
    {{-- Filter Header (Mobile Only) --}}
    <div class="d-lg-none mb-3">
        <button class="btn btn-navy w-100 d-flex align-items-center justify-content-between p-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
            <span><i class="bi bi-funnel me-2"></i> Filter & Urutkan</span>
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <div class="row">
        <!-- Sidebar Filter (Desktop) & Offcanvas (Mobile) -->
        <div class="col-lg-3">
            <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="filterSidebar">
                <div class="offcanvas-header bg-navy text-white d-lg-none">
                    <h5 class="offcanvas-title">Filter Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <div class="card border-0 border-lg shadow-sm w-100">
                        <div class="card-header bg-navy text-white d-none d-lg-block">
                            <h5 class="mb-0"><i class="bi bi-funnel"></i> Filter</h5>
                        </div>
                        <div class="card-body p-4 p-lg-3">
                            <form action="{{ route('products.index') }}" method="GET">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                
                                <div class="mb-4 mb-lg-3">
                                    <label class="form-label fw-bold small text-uppercase">Kategori</label>
                                    <select name="category" class="form-select">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-4 mb-lg-3">
                                    <label class="form-label fw-bold small text-uppercase">Kondisi</label>
                                    <select name="condition" class="form-select">
                                        <option value="">Semua Kondisi</option>
                                        <option value="baru" {{ request('condition') == 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="seperti_baru" {{ request('condition') == 'seperti_baru' ? 'selected' : '' }}>Seperti Baru</option>
                                        <option value="bekas" {{ request('condition') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4 mb-lg-3">
                                    <label class="form-label fw-bold small text-uppercase">Harga Minimum</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">Rp</span>
                                        <input type="number" name="min_price" class="form-control" value="{{ request('min_price') }}" placeholder="0">
                                    </div>
                                </div>
                                
                                <div class="mb-4 mb-lg-3">
                                    <label class="form-label fw-bold small text-uppercase">Harga Maksimum</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">Rp</span>
                                        <input type="number" name="max_price" class="form-control" value="{{ request('max_price') }}" placeholder="Tanpa batas">
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-navy w-100 py-2 fw-bold">
                                    <i class="bi bi-check-lg me-1"></i> Terapkan
                                </button>
                                
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2 py-2 small">
                                    Reset Filter
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Daftar Produk -->
        <div class="col-lg-9">
            @if(request('search'))
                <div class="alert alert-info">
                    Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                    ({{ $products->total() }} produk ditemukan)
                </div>
            @endif
            
            <div class="row">
                @forelse($products as $product)
                <div class="col-md-4 col-6 mb-4">
                    <div class="card-product">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <span class="badge-condition">
                                {{ $product->condition == 'baru' ? 'Baru' : ($product->condition == 'seperti_baru' ? 'Spt Baru' : 'Bekas') }}
                            </span>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($product->name, 45) }}</h6>
                            <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="seller-info">
                                <span class="seller-name text-truncate">
                                    <i class="bi bi-person-circle"></i> {{ $product->user->name }}
                                </span>
                                <a href="{{ route('products.show', $product) }}" class="btn-navy btn-sm" style="padding: 0.25rem 0.65rem; font-size: 0.75rem;">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-triangle"></i> Tidak ada produk ditemukan.
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection