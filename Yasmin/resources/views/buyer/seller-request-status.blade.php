@extends('layouts.app')

@section('title', 'Status Permohonan Seller - Preloved Market')

@push('styles')
<style>
    .status-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
    }
    
    .status-card-header {
        background: var(--navy);
        color: white;
        padding: 1.5rem 2rem;
    }
    
    .status-card-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .status-card-body {
        padding: 2rem;
    }
    
    .status-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
    }
    
    .status-icon.pending { color: #f59e0b; }
    .status-icon.approved { color: #10b981; }
    .status-icon.rejected { color: #ef4444; }
    
    .status-badge {
        display: inline-block;
        padding: 0.35rem 1.2rem;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-badge.approved {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-badge.rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .info-box {
        background: #f8fafc;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
    }
    
    .btn-dashboard {
        background: var(--navy);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.7rem 2rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-dashboard:hover {
        background: var(--navy-mid);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show mb-4">
                    <i class="bi bi-info-circle"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="status-card">
                <div class="status-card-header">
                    <h3><i class="bi bi-shop"></i> Status Permohonan Seller</h3>
                </div>
                
                <div class="status-card-body text-center">
                    
                    {{-- Icon Status --}}
                    <div class="status-icon {{ $sellerRequest->status }}">
                        @if($sellerRequest->status == 'pending')
                            <i class="bi bi-hourglass-split"></i>
                        @elseif($sellerRequest->status == 'approved')
                            <i class="bi bi-check-circle-fill"></i>
                        @else
                            <i class="bi bi-x-circle-fill"></i>
                        @endif
                    </div>
                    
                    {{-- Status Badge --}}
                    <div class="mb-4">
                        <span class="status-badge {{ $sellerRequest->status }}">
                            @if($sellerRequest->status == 'pending')
                                Menunggu Verifikasi
                            @elseif($sellerRequest->status == 'approved')
                                Disetujui
                            @else
                                Ditolak
                            @endif
                        </span>
                    </div>
                    
                    {{-- Pesan Status --}}
                    <div class="mb-4">
                        @if($sellerRequest->status == 'pending')
                            <h5>Permohonan Anda Sedang Diproses</h5>
                            <p class="text-muted">
                                Admin akan memverifikasi data Anda dalam 1x24 jam. 
                                Silakan cek secara berkala.
                            </p>
                        @elseif($sellerRequest->status == 'approved')
                            <h5 class="text-success">Selamat! Permohonan Anda Disetujui</h5>
                            <p class="text-muted">
                                Anda sekarang sudah menjadi seller. Silakan mulai upload produk Anda.
                            </p>
                            <a href="{{ route('seller.dashboard') }}" class="btn-dashboard">
                                <i class="bi bi-speedometer2"></i> Ke Dashboard Seller
                            </a>
                        @else
                            <h5 class="text-danger">Permohonan Ditolak</h5>
                            @if($sellerRequest->admin_note)
                                <div class="alert alert-danger mt-3">
                                    <strong>Alasan:</strong> {{ $sellerRequest->admin_note }}
                                </div>
                            @endif
                            <p class="text-muted mt-3">
                                Silakan perbaiki data Anda dan ajukan ulang.
                            </p>
                            <a href="{{ route('seller.request') }}" class="btn btn-warning mt-2">
                                <i class="bi bi-pencil"></i> Ajukan Ulang
                            </a>
                        @endif
                    </div>
                    
                    <hr class="my-4">
                    
                    {{-- Detail Permohonan --}}
                    <div class="info-box text-start">
                        <h6 class="mb-3">Detail Permohonan:</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="120">Nama Toko</th>
                                <td>: {{ $sellerRequest->shop_name }}</td>
                            </tr>
                            <tr>
                                <th>WhatsApp</th>
                                <td>: {{ $sellerRequest->whatsapp_number }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Ajukan</th>
                                <td>: {{ $sellerRequest->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            @if($sellerRequest->reviewed_at)
                            <tr>
                                <th>Diverifikasi</th>
                                <td>: {{ $sellerRequest->reviewed_at->format('d M Y H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    
                    {{-- Tombol Kembali --}}
                    <div class="mt-4">
                        <a href="{{ route('buyer.dashboard') }}" class="btn btn-outline-navy">
                            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection