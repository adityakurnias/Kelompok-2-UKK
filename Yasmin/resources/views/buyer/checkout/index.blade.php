@extends('layouts.app')

@section('title', 'Checkout - Preloved Market')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-navy mb-4">
                <i class="bi bi-cart-check"></i> Checkout
            </h2>
        </div>
    </div>
    
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-navy text-white">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                        @csrf
                        
                        {{-- Hidden inputs for selected items --}}
                        @foreach($cartItems as $item)
                            <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                        @endforeach
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Pembeli <span class="text-danger">*</span></label>
                                <input type="text" name="buyer_name" class="form-control" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" name="buyer_email" class="form-control" value="{{ Auth::user()->email }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Pengiriman <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" 
                                      rows="3" required>{{ old('shipping_address', Auth::user()->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="form-check border p-3 rounded">
                                        <input class="form-check-input" type="radio" name="payment_method" 
                                               id="transfer" value="transfer_bank" checked>
                                        <label class="form-check-label" for="transfer">
                                            <strong>Transfer Bank</strong><br>
                                            <small class="text-muted">BCA / Mandiri / BNI / BRI</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-check border p-3 rounded">
                                        <input class="form-check-input" type="radio" name="payment_method" 
                                               id="cod" value="cod">
                                        <label class="form-check-label" for="cod">
                                            <strong>COD (Cash on Delivery)</strong><br>
                                            <small class="text-muted">Bayar di tempat</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3" id="proofUploadSection">
                            <label class="form-label">Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file" name="payment_proof" class="form-control @error('payment_proof') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="alert alert-info mt-2">
                                <i class="bi bi-info-circle"></i> 
                                <strong>Rekening Pembayaran:</strong><br>
                                BCA: 1234567890 a.n. Preloved Market<br>
                                Mandiri: 9876543210 a.n. Preloved Market
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-navy text-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item->product->name }} ({{ $item->quantity }}x)</span>
                            <span>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <hr>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td>Subtotal</td>
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
                    
                    <button type="submit" form="checkoutForm" class="btn btn-navy w-100">
                        <i class="bi bi-check-circle"></i> Buat Pesanan
                    </button>
                    
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-navy w-100 mt-2">
                        <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const transferRadio = document.getElementById('transfer');
        const codRadio = document.getElementById('cod');
        const proofSection = document.getElementById('proofUploadSection');
        
        function toggleProofSection() {
            if (codRadio.checked) {
                proofSection.style.display = 'none';
                document.querySelector('input[name="payment_proof"]').removeAttribute('required');
            } else {
                proofSection.style.display = 'block';
                document.querySelector('input[name="payment_proof"]').setAttribute('required', 'required');
            }
        }
        
        transferRadio.addEventListener('change', toggleProofSection);
        codRadio.addEventListener('change', toggleProofSection);
        
        // Initial state
        toggleProofSection();
    });
</script>
@endpush
@endsection