@extends('layouts.app')

@section('title', 'Ajukan Jadi Seller - Preloved Market')

@push('styles')
<style>
    .form-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
    }
    
    .form-card-header {
        background: var(--navy);
        color: white;
        padding: 1.5rem 2rem;
    }
    
    .form-card-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .form-card-header p {
        opacity: 0.8;
        margin: 0;
        font-size: 0.9rem;
    }
    
    .form-card-body {
        padding: 2rem;
    }
    
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--navy);
        margin-bottom: 0.35rem;
    }
    
    .required-star {
        color: #e53e3e;
        margin-left: 2px;
    }
    
    .form-control, .form-select {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--navy);
        box-shadow: 0 0 0 3px rgba(15,36,68,0.08);
        outline: none;
    }
    
    .info-box {
        background: #f0f9ff;
        border: 1.5px solid #bae6fd;
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    
    .info-box i {
        font-size: 1.2rem;
        color: #0369a1;
    }
    
    .info-box p {
        margin: 0;
        font-size: 0.85rem;
        color: #0c4a6e;
    }
    
    .btn-submit {
        background: var(--navy);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.7rem 2rem;
        font-size: 0.95rem;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-submit:hover {
        background: var(--navy-mid);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(15,36,68,0.2);
    }
    
    .btn-submit i {
        margin-right: 0.5rem;
    }
    
    .btn-back {
        background: white;
        color: var(--navy);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.7rem 2rem;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-back:hover {
        border-color: var(--navy);
        color: var(--navy);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Alert jika ada error --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            {{-- Form Card --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h3><i class="bi bi-shop"></i> Ajukan Jadi Seller</h3>
                    <p>Isi data dengan lengkap untuk menjadi seller di Preloved Market</p>
                </div>
                
                <div class="form-card-body">
                    
                    {{-- Info Box --}}
                    <div class="info-box">
                        <i class="bi bi-info-circle-fill"></i>
                        <p>
                            <strong>Perhatian:</strong> Data Anda akan diverifikasi oleh admin dalam 1x24 jam. 
                            Pastikan data yang dimasukkan benar dan valid.
                        </p>
                    </div>
                    
                    {{-- Form --}}
                    <form action="{{ route('seller.request.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Nama Toko --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Nama Toko <span class="required-star">*</span>
                            </label>
                            <input type="text" 
                                   name="shop_name" 
                                   class="form-control @error('shop_name') is-invalid @enderror" 
                                   value="{{ old('shop_name') }}"
                                   placeholder="Contoh: Toko Fashion Budi"
                                   required>
                            @error('shop_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Deskripsi Toko --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Deskripsi Toko <span class="required-star">*</span>
                            </label>
                            <textarea name="shop_description" 
                                      class="form-control @error('shop_description') is-invalid @enderror" 
                                      rows="4"
                                      placeholder="Ceritakan tentang toko Anda, produk apa yang akan dijual, dll. Minimal 20 karakter."
                                      required>{{ old('shop_description') }}</textarea>
                            <small class="text-muted">Minimal 20 karakter</small>
                            @error('shop_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Alamat Toko --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Alamat Toko <span class="required-star">*</span>
                            </label>
                            <textarea name="shop_address" 
                                      class="form-control @error('shop_address') is-invalid @enderror" 
                                      rows="2"
                                      placeholder="Alamat lengkap toko Anda"
                                      required>{{ old('shop_address') }}</textarea>
                            @error('shop_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Nomor WhatsApp --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Nomor WhatsApp <span class="required-star">*</span>
                            </label>
                            <input type="text" 
                                   name="whatsapp_number" 
                                   class="form-control @error('whatsapp_number') is-invalid @enderror" 
                                   value="{{ old('whatsapp_number', Auth::user()->phone) }}"
                                   placeholder="08123456789"
                                   required>
                            @error('whatsapp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Upload KTP --}}
                        <div class="mb-4">
                            <label class="form-label">
                                Foto KTP <span class="required-star">*</span>
                            </label>
                            <input type="file" 
                                   name="ktp_image" 
                                   class="form-control @error('ktp_image') is-invalid @enderror" 
                                   accept="image/*"
                                   required>
                            <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                            @error('ktp_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('buyer.dashboard') }}" class="btn-back">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="bi bi-send"></i> Ajukan Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection