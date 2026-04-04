@extends('layouts.app')

@section('title', 'Daftar Produk - Preloved Market')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-navy text-white">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> Filter</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Kondisi</label>
                            <select name="condition" class="form-select">
                                <option value="">Semua Kondisi</option>
                                <option value="baru" {{ request('condition') == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="seperti_baru" {{ request('condition') == 'seperti_baru' ? 'selected' : '' }}>Seperti Baru</option>
                                <option value="bekas" {{ request('condition') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Harga Minimum</label>
                            <input type="number" name="min_price" class="form-control" value="{{ request('min_price') }}" placeholder="Rp">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Harga Maksimum</label>
                            <input type="number" name="max_price" class="form-control" value="{{ request('max_price') }}" placeholder="Rp">
                        </div>
                        
                        <button type="submit" class="btn btn-navy w-100">
                            <i class="bi bi-search"></i> Terapkan Filter
                        </button>
                        
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Reset Filter
                        </a>
                    </form>
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
                        <div class="position-relative">
                            <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <span class="badge-condition">
                                @if($product->condition == 'baru')
                                    Baru
                                @elseif($product->condition == 'seperti_baru')
                                    Seperti Baru
                                @else
                                    Bekas
                                @endif
                            </span>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                            <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-person-circle"></i> {{ $product->user->name }}
                                </small>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-navy btn-sm">
                                    Detail
                                </a>
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