@push('styles')
<style>
    .order-card {
        background: white;
        border: 1.2px solid var(--border);
        border-radius: 16px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .order-card:hover {
        box-shadow: 0 10px 25px rgba(15,36,68,0.06);
    }

    .order-card-header {
        padding: 1.25rem 1.5rem;
        background: #f8fafc;
        border-bottom: 1px solid var(--border);
    }

    .order-card-body {
        padding: 1.5rem;
    }

    .order-card-footer {
        padding: 1.25rem 1.5rem;
        background: white;
        border-top: 1px solid var(--border);
    }

    .product-img-fixed {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        object-fit: cover;
        background: #f1f5f9;
    }

    /* Soft Badges */
    .badge-pill-modern {
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }

    .badge-soft-pending { background: #fffbeb; color: #92400e; }
    .badge-soft-confirmed { background: #f0f9ff; color: #075985; }
    .badge-soft-shipped { background: #f5f3ff; color: #5b21b6; }
    .badge-soft-completed { background: #f0fdf4; color: #166534; }
    .badge-soft-cancelled { background: #fef2f2; color: #991b1b; }

    .btn-modern {
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
    }

    .info-alert {
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.8rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-top: 1rem;
    }
</style>
@endpush

@if($orders->count() > 0)
    <div class="orders-card-wrapper pb-5">
        @foreach($orders as $order)
        <div class="order-card">
            {{-- Header: No Order & Status --}}
            <div class="order-card-header">
                <div class="row align-items-center g-3">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center flex-wrap gap-2 gap-md-4">
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">No. Order</small>
                                <span class="fw-bold text-navy">{{ $order->order_number }}</span>
                            </div>
                            <div class="d-none d-md-block border-start h-100 mx-2" style="width: 1px; height: 24px !important;"></div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Tanggal Pesanan</small>
                                <span class="small text-navy">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        @php
                            $statusSlug = $order->status;
                            $statusLabel = [
                                'pending' => 'Pending',
                                'confirmed' => 'Dikonfirmasi',
                                'shipped' => 'Dikirim',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan'
                            ][$statusSlug] ?? ucfirst($statusSlug);
                        @endphp
                        <span class="badge badge-pill-modern badge-soft-{{ $statusSlug }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>
            </div>
            
            {{-- Body: Item List --}}
            <div class="order-card-body">
                @foreach($order->items as $item)
                <div class="row align-items-center g-3">
                    <div class="col-auto">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="product-img-fixed border">
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h6 class="mb-1 fw-bold text-navy">{{ $item->product->name }}</h6>
                                <div class="text-muted small">
                                    {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    @if($item->product->user)
                                        <span class="mx-2">|</span>
                                        <i class="bi bi-shop me-1"></i>{{ $item->product->user->name }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-end mt-2 mt-lg-0">
                                <span class="fw-bold text-navy">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!$loop->last)
                    <hr class="my-3 opacity-25">
                @endif
                @endforeach
            </div>
            
            {{-- Footer: Payment & Actions --}}
            <div class="order-card-footer">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <div class="small text-muted">
                                <i class="bi bi-wallet2 me-1"></i> 
                                {{ $order->payment_method == 'transfer_bank' ? 'Transfer Bank' : 'COD' }}
                            </div>
                            @if($order->payment_method == 'transfer_bank' && $order->payment_proof)
                                <a href="{{ asset('storage/payments/' . $order->payment_proof) }}" target="_blank" 
                                   class="btn btn-sm btn-outline-info rounded-pill px-3 py-1" style="font-size: 0.7rem; font-weight: 700;">
                                    <i class="bi bi-receipt me-1"></i> Bukti Bayar
                                </a>
                            @endif
                            <div class="fw-bold text-navy">
                                <small class="text-muted fw-normal">Total:</small>
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 text-md-end">
                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-navy btn-modern">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            
                            @if($order->status == 'pending')
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger btn-modern" 
                                            onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </button>
                                </form>
                            @endif
                            
                            @if($order->status == 'shipped')
                                <form action="{{ route('orders.confirm-receipt', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-modern px-3" 
                                            onclick="return confirm('Pastikan Anda sudah menerima barang?')">
                                        <i class="bi bi-check-circle"></i> Selesai
                                    </button>
                                </form>
                            @endif
                            
                            @if($order->status == 'completed')
                                <a href="{{ route('products.index') }}" class="btn btn-outline-success btn-modern">
                                    <i class="bi bi-bag-plus"></i> Beli Lagi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- Status Messages --}}
                @if($order->status == 'shipped')
                    <div class="info-alert bg-light text-primary border">
                        <i class="bi bi-info-circle-fill fs-6 mt-1"></i>
                        <div><b>Pesanan dikirim.</b> Jangan lupa konfirmasi setelah barang sampai ya!</div>
                    </div>
                @elseif($order->status == 'pending')
                    <div class="info-alert bg-light text-warning border">
                        <i class="bi bi-clock-history fs-6 mt-1"></i>
                        <div>
                            <b>Menunggu konfirmasi.</b> Pelapak akan segera memproses pesananmu.
                            @if($order->payment_method == 'transfer_bank' && !$order->payment_proof)
                                <br><span class="text-danger fw-bold">Segera upload bukti bayar di halaman detail.</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-inbox text-muted" style="font-size: 4rem; opacity: 0.2;"></i>
        </div>
        <h4 class="fw-bold text-navy">Belum Ada Pesanan</h4>
        <p class="text-muted mb-4 px-4">Anda belum memiliki riwayat pemesanan di kategori ini.</p>
        <a href="{{ route('products.index') }}" class="btn btn-navy px-4 py-2" style="border-radius: 12px;">
            <i class="bi bi-shop me-2"></i> Mulai Belanja
        </a>
    </div>
@endif