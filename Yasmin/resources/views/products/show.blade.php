@extends('layouts.app')
@section('title', $product->name . ' - Preloved Market')

@push('styles')
    <style>
        .detail-wrapper {
            padding: 2rem 0 5rem;
            background: var(--soft);
            min-height: 80vh;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1.75rem;
            font-size: 0.82rem;
        }

        .breadcrumb-item a {
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-item a:hover {
            color: var(--navy);
        }

        .breadcrumb-item.active {
            color: var(--ink);
            font-weight: 500;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: var(--border);
        }

        /* Image Panel */
        .img-panel {
            background: white;
            border-radius: 18px;
            border: 1.5px solid var(--border);
            overflow: hidden;
            position: sticky;
            top: 1.5rem;
        }

        .img-panel img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            display: block;
        }

        .img-panel-footer {
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid var(--border);
        }

        .img-panel-footer .condition-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--soft);
            border: 1.5px solid var(--border);
            border-radius: 20px;
            padding: 0.3rem 0.85rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--ink);
        }

        .img-panel-footer .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #48bb78;
            display: inline-block;
        }

        .img-panel-footer .status-dot.sold {
            background: #e53e3e;
        }

        /* Info Panel */
        .info-panel {
            background: white;
            border-radius: 18px;
            border: 1.5px solid var(--border);
            padding: 2rem 2rem 1.75rem;
        }

        .category-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(15, 36, 68, 0.06);
            color: var(--navy);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            margin-bottom: 0.85rem;
        }

        .product-name {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.4rem, 3vw, 1.9rem);
            font-weight: 700;
            color: var(--navy);
            line-height: 1.25;
            margin-bottom: 1rem;
        }

        .product-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0;
        }

        .price-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.1rem 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            margin-bottom: 1.5rem;
        }

        .price-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted);
        }

        /* Description */
        .desc-section {
            margin-bottom: 1.5rem;
        }

        .section-heading {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.6rem;
        }

        .desc-text {
            font-size: 0.9rem;
            color: #444;
            line-height: 1.75;
            margin: 0;
        }

        /* Seller Card */
        .seller-card {
            background: var(--soft);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 1.1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .seller-avatar {
            width: 48px;
            height: 48px;
            background: var(--navy);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .seller-info h6 {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--navy);
            margin-bottom: 0.2rem;
        }

        .seller-info p {
            font-size: 0.8rem;
            color: var(--muted);
            margin: 0;
            line-height: 1.6;
        }

        /* Action Buttons */
        .btn-add-cart {
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            flex: 1;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-add-cart:hover {
            background: var(--navy-mid);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15, 36, 68, 0.2);
        }

        .btn-whatsapp {
            background: #25d366;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-whatsapp:hover {
            background: #1fba5a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.25);
        }

        .btn-edit {
            background: white;
            color: var(--navy);
            border: 1.5px solid var(--navy);
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: var(--navy);
            color: white;
        }

        .action-row {
            display: flex;
            gap: 0.75rem;
        }

        .sold-notice {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #fff5f5;
            border: 1.5px solid #fed7d7;
            border-radius: 12px;
            padding: 0.9rem 1.1rem;
            font-size: 0.875rem;
            color: #c53030;
            font-weight: 500;
        }

        /* Related Products */
        .related-section {
            margin-top: 3.5rem;
        }

        .related-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .related-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--navy);
            margin: 0;
        }

        .related-header a {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--navy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .related-header a:hover {
            text-decoration: underline;
        }

        /* Alert styles */
        .alert-success {
            background: #f0fff4;
            border: 1.5px solid #c6f6d5;
            border-radius: 12px;
            color: #276749;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-danger {
            background: #fff5f5;
            border: 1.5px solid #fed7d7;
            border-radius: 12px;
            color: #c53030;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
    </style>
@endpush

@section('content')
    <div class="detail-wrapper">
        <div class="container">

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Beranda</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
                </ol>
            </nav>

            <div class="row g-4">

                {{-- Image --}}
                <div class="col-lg-5">
                    <div class="img-panel">
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}">
                        <div class="img-panel-footer">
                            <span class="condition-badge">
                                <i class="bi bi-tag"></i>
                                {{ $product->condition == 'baru' ? 'Baru' : ($product->condition == 'seperti_baru' ? 'Seperti Baru' : 'Bekas') }}
                            </span>
                            <span style="font-size:0.8rem;font-weight:600;display:flex;align-items:center;gap:0.4rem">
                                <span class="status-dot {{ $product->status != 'tersedia' ? 'sold' : '' }}"></span>
                                {{ $product->status == 'tersedia' ? 'Tersedia' : 'Terjual' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="col-lg-7">
                    <div class="info-panel">

                        <div class="category-chip">
                            <i class="bi bi-tag-fill"></i>
                            {{ $product->category->name }}
                        </div>

                        <h1 class="product-name">{{ $product->name }}</h1>

                        <div class="price-row">
                            <div>
                                <div class="price-label">Harga</div>
                                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="desc-section">
                            <div class="section-heading">Deskripsi Produk</div>
                            <p class="desc-text">{{ $product->description }}</p>
                        </div>

                        {{-- Seller --}}
                        <div class="section-heading">Penjual</div>
                        <div class="seller-card">
                            <div class="seller-avatar">
                                @if($product->user->photo)
                                    <img src="{{ asset('storage/users/' . $product->user->photo) }}"
                                        alt="{{ $product->user->name }}"
                                        style="width:100%;height:100%;object-fit:cover;border-radius:14px;">
                                @else
                                    <i class="bi bi-person-fill"></i>
                                @endif
                            </div>
                            <div class="seller-info">
                                <h6>{{ $product->user->name }}</h6>
                                <p>
                                    <i class="bi bi-telephone me-1"></i>{{ $product->user->phone ?? '-' }}<br>
                                    <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($product->user->address ?? '-', 30) }}
                                </p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        @auth
                            @if(Auth::id() != $product->user_id)
                                @if($product->status == 'tersedia')
                                    <div class="action-row">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex:1">
                                            @csrf
                                            <button type="submit" class="btn-add-cart w-100">
                                                <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                            </button>
                                        </form>
                                        <div class="btn-whatsapp"
                                            style="cursor: default; pointer-events: none; background: #eaedf0; color: #0f2444;">
                                            <i class="bi bi-telephone"></i> {{ $product->user->phone ?? 'Tidak ada nomor' }}
                                        </div>
                                    </div>
                                @else
                                    <div class="sold-notice">
                                        <i class="bi bi-x-circle-fill fs-5"></i>
                                        Produk ini sudah tidak tersedia
                                    </div>
                                @endif
                            @else
                                <div class="action-row">
                                    <a href="{{ route('seller.products.edit', $product) }}" class="btn-edit">
                                        <i class="bi bi-pencil"></i> Edit Produk
                                    </a>
                                    <button type="button" class="btn-edit" style="border-color:#e53e3e;color:#e53e3e;"
                                        onclick="confirmDelete({{ $product->id }})">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                    <form id="delete-form-{{ $product->id }}"
                                        action="{{ route('seller.products.delete', $product) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="action-row">
                                <a href="{{ route('login') }}" class="btn-add-cart">
                                    <i class="bi bi-box-arrow-in-right"></i> Login untuk Membeli
                                </a>
                            </div>
                        @endauth

                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="related-section">
                    <div class="related-header">
                        <h3>Produk Terkait</h3>
                        <a href="{{ route('products.index', ['category' => $product->category_id]) }}">
                            Lihat semua <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="row g-3">
                        @foreach($relatedProducts as $related)
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card-product">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/products/' . $related->image) }}" alt="{{ $related->name }}">
                                        <span class="badge-condition">
                                            {{ $related->condition == 'baru' ? 'Baru' : ($related->condition == 'seperti_baru' ? 'Seperti Baru' : 'Bekas') }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-title"
                                            style="font-size:0.88rem;font-weight:600;color:var(--ink);margin-bottom:0.3rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.4">
                                            {{ $related->name }}</p>
                                        <p class="price">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                        <div
                                            style="display:flex;align-items:center;justify-content:space-between;margin-top:0.5rem">
                                            <span style="font-size:0.75rem;color:var(--muted)"><i
                                                    class="bi bi-person-circle me-1"></i>{{ $related->user->name }}</span>
                                            <a href="{{ route('products.show', $related) }}" class="btn-navy"
                                                style="font-size:0.78rem;padding:0.35rem 0.85rem;border-radius:6px;text-decoration:none">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(productId) {
                if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    document.getElementById('delete-form-' + productId).submit();
                }
            }
        </script>
    @endpush
@endsection