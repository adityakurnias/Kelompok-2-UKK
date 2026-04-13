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
    
    
    <form id="cartForm" action="{{ route('checkout.index') }}" method="GET">
    <div class="row">
        @if($cartItems->count() > 0)
            <div class="col-lg-8">
                {{-- Header Pilih Semua --}}
                <div class="card mb-3">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input m-0 me-3" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-bold" for="selectAll" style="cursor: pointer; padding-top: 2px;">
                                Pilih Semua ({{ $cartItems->count() }} barang)
                            </label>
                        </div>
                    </div>
                </div>
                
                {{-- Daftar Produk di Keranjang --}}
                @foreach($cartItems as $item)
                <div class="card mb-3 cart-item-card">
                    <div class="card-body py-3">
                        <div class="row align-items-center g-2 g-md-3">
                            {{-- Checkbox --}}
                            <div class="col-auto">
                                <input class="form-check-input item-checkbox m-0" type="checkbox" name="selected_items[]" value="{{ $item->id }}" data-price="{{ $item->product->price }}" data-qty="{{ $item->quantity }}">
                            </div>
                            
                            {{-- Image --}}
                            <div class="col-3 col-md-2 text-center">
                                <img src="{{ $item->product->image_url }}" class="img-fluid rounded shadow-sm cart-img-preview" alt="{{ $item->product->name }}">
                            </div>
                            
                            {{-- Info --}}
                            <div class="col-7 col-md-4 ps-1 ps-md-3">
                                <h6 class="mb-0 text-truncate" style="font-size: 0.9rem;">{{ $item->product->name }}</h6>
                                <p class="text-muted mb-1 small d-none d-md-block">
                                    Penjual: <b>{{ $item->product->user->name }}</b>
                                </p>
                                <p class="text-navy fw-bold mb-0" style="font-size: 0.85rem;">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }} <span class="text-muted fw-normal d-none d-sm-inline" style="font-size: 0.7rem;">/ item</span>
                                </p>
                            </div>
                            
                            {{-- Qty & Total (Stacked on mobile, row on desktop) --}}
                            <div class="col-12 col-md-5 mt-2 mt-md-0">
                                <div class="row align-items-center">
                                    <div class="col-6 col-md-6 d-flex justify-content-start justify-content-md-center">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center cart-update-form">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                   min="1" class="form-control form-control-sm me-2 qty-input" 
                                                   data-price="{{ $item->product->price }}"
                                                   style="width: 55px; text-align: center;">
                                            <button type="submit" class="btn btn-sm btn-outline-navy btn-update-qty d-none">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-6 col-md-6 text-end">
                                        <div class="d-flex flex-column align-items-end">
                                            <span class="fw-bold text-navy" style="font-size: 0.95rem;">
                                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            </span>
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="remove-item-form mt-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 small text-decoration-none" onclick="return confirm('Hapus produk ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                        
                        <button type="submit" id="checkoutBtn" class="btn btn-navy w-100 py-2 fw-bold" disabled>
                            <i class="bi bi-cart-check"></i> Checkout
                        </button>
                        
                        <a href="{{ route('products.index') }}" class="btn btn-outline-navy w-100 mt-2 py-2 small">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>

@push('styles')
<style>
    /* Custom Checkbox Styling */
    .form-check-input.item-checkbox, 
    .form-check-input#selectAll {
        width: 1.5rem;
        height: 1.5rem;
        cursor: pointer;
        border: 2px solid var(--navy) !important;
    }

    .form-check-input:checked {
        background-color: var(--navy);
        border-color: var(--navy);
    }

    .cart-item-card {
        transition: all 0.3s ease;
        border: 1.5px solid var(--border) !important;
        border-radius: 12px;
    }

    .cart-item-card:hover {
        border-color: var(--navy) !important;
        background-color: #fcfcfc;
    }

    .item-checkbox-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-img-preview {
        width: 70px;
        height: 70px;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .cart-img-preview { width: 60px; height: 60px; }
        .qty-input { width: 45px !important; }
    }
</style>
@endpush
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
    </form>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const qtyInputs = document.querySelectorAll('.qty-input');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const subtotalTextFinal = document.querySelector('.text-end.text-navy');
        const subtotalTextRaw = document.querySelector('.table-borderless td.text-end');
        
        // Select All logic
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                itemCheckboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                calculateSubtotal();
                toggleCheckoutBtn();
            });
        }
        
        // Individual checkbox change
        itemCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (!this.checked) selectAll.checked = false;
                if (document.querySelectorAll('.item-checkbox:checked').length === itemCheckboxes.length) {
                    selectAll.checked = true;
                }
                calculateSubtotal();
                toggleCheckoutBtn();
            });
        });

        qtyInputs.forEach(input => {
            input.addEventListener('input', function() {
                const qty = parseInt(this.value) || 0;
                const price = parseFloat(this.getAttribute('data-price'));
                const rowTotalElement = this.closest('.row').querySelector('.fw-bold.mb-2');
                
                if (rowTotalElement) {
                    const total = qty * price;
                    rowTotalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                }
                
                // Update the data-qty attribute on the corresponding checkbox
                const checkbox = this.closest('.card-body').querySelector('.item-checkbox');
                if (checkbox) {
                    checkbox.setAttribute('data-qty', qty);
                }
                
                // Show the update button
                this.nextElementSibling.classList.remove('d-none');
                
                calculateSubtotal();
            });
        });
        
        function toggleCheckoutBtn() {
            const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
            checkoutBtn.disabled = checkedCount === 0;
        }
        
        function calculateSubtotal() {
            let subtotalSelected = 0;
            const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
            
            checkedBoxes.forEach(cb => {
                const qty = parseInt(cb.getAttribute('data-qty')) || 0;
                const price = parseFloat(cb.getAttribute('data-price')) || 0;
                subtotalSelected += qty * price;
            });
            
            const table = document.querySelector('.table-borderless');
            if (table) {
                const cells = table.querySelectorAll('td.text-end');
                if (cells.length >= 1) {
                    const formatted = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotalSelected);
                    cells[0].textContent = formatted; // Total Harga
                    cells[2].textContent = formatted; // Total Final
                }
            }
            
            // Basic UI feedback for checkout count
            const btn = document.getElementById('checkoutBtn');
            if (btn) {
                btn.innerHTML = `<i class="bi bi-cart-check"></i> Checkout (${checkedBoxes.length})`;
            }
        }
        
        // Initial calc
        calculateSubtotal();
        toggleCheckoutBtn();
    });
</script>
@endpush
@endsection