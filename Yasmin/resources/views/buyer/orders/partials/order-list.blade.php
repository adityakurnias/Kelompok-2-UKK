@if($orders->count() > 0)
    @foreach($orders as $order)
    <div class="card mb-3 border">
        <div class="card-header bg-light">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <small class="text-muted">No. Order</small>
                    <h6 class="mb-0">{{ $order->order_number }}</h6>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Tanggal</small>
                    <p class="mb-0">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Total</small>
                    <p class="mb-0 fw-bold text-navy">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-2 text-end">
                    @php
                        $statusClass = [
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'shipped' => 'primary',
                            'completed' => 'success',
                            'cancelled' => 'danger'
                        ][$order->status] ?? 'secondary';
                        
                        $statusText = [
                            'pending' => 'Pending',
                            'confirmed' => 'Dikonfirmasi',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan'
                        ][$order->status] ?? ucfirst($order->status);
                    @endphp
                    <span class="badge bg-{{ $statusClass }}">
                        {{ $statusText }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @foreach($order->items as $item)
            <div class="row mb-2 align-items-center">
                <div class="col-2 col-md-1">
                    <img src="{{ asset('storage/products/' . $item->product->image) }}" 
                         width="50" height="50" class="rounded" style="object-fit: cover;">
                </div>
                <div class="col-6 col-md-7">
                    <p class="mb-0 fw-bold">{{ $item->product->name }}</p>
                    <small class="text-muted">
                        {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                    </small>
                    @if($item->product->user)
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-shop"></i> Penjual: {{ $item->product->user->name }}
                        </small>
                    @endif
                </div>
                <div class="col-4 text-end">
                    <p class="mb-0 fw-bold text-navy">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
            </div>
            @if(!$loop->last)
                <hr class="my-2">
            @endif
            @endforeach
        </div>
        
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <small class="text-muted">
                        <i class="bi bi-credit-card"></i> 
                        {{ $order->payment_method == 'transfer_bank' ? 'Transfer Bank' : 'COD (Cash on Delivery)' }}
                    </small>
                    
                    @if($order->payment_method == 'transfer_bank' && $order->payment_proof)
                        <a href="{{ asset('storage/payments/' . $order->payment_proof) }}" target="_blank" 
                           class="btn btn-sm btn-outline-info ms-2">
                            <i class="bi bi-eye"></i> Lihat Bukti Bayar
                        </a>
                    @endif
                </div>
                
                <div class="d-flex gap-2">
                    {{-- Tombol Lihat Detail --}}
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-navy">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                    
                    {{-- Tombol Batalkan (hanya untuk status pending) --}}
                    @if($order->status == 'pending')
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                    onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                <i class="bi bi-x-circle"></i> Batalkan
                            </button>
                        </form>
                    @endif
                    
                    {{-- Tombol Konfirmasi Penerimaan (hanya untuk status shipped) --}}
                    @if($order->status == 'shipped')
                        <form action="{{ route('orders.confirm-receipt', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-success" 
                                    onclick="return confirm('Pastikan Anda sudah menerima barang?')">
                                <i class="bi bi-check-circle"></i> Konfirmasi Diterima
                            </button>
                        </form>
                    @endif
                    
                    {{-- Tombol Beli Lagi (untuk status completed) --}}
                    @if($order->status == 'completed')
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-cart-plus"></i> Beli Lagi
                        </a>
                    @endif
                </div>
            </div>
            
            {{-- Informasi Tambahan --}}
            @if($order->status == 'shipped')
                <div class="mt-2 p-2 bg-light rounded">
                    <small class="text-primary">
                        <i class="bi bi-truck"></i> Pesanan sedang dalam perjalanan. Jangan lupa konfirmasi setelah barang diterima.
                    </small>
                </div>
            @elseif($order->status == 'pending')
                <div class="mt-2 p-2 bg-light rounded">
                    <small class="text-warning">
                        <i class="bi bi-clock-history"></i> Menunggu konfirmasi penjual. 
                        @if($order->payment_method == 'transfer_bank' && !$order->payment_proof)
                            <br>Silakan upload bukti pembayaran di halaman detail.
                        @endif
                    </small>
                </div>
            @elseif($order->status == 'confirmed')
                <div class="mt-2 p-2 bg-light rounded">
                    <small class="text-info">
                        <i class="bi bi-check-circle"></i> Pesanan telah dikonfirmasi penjual. Menunggu pengiriman.
                    </small>
                </div>
            @elseif($order->status == 'completed')
                <div class="mt-2 p-2 bg-light rounded">
                    <small class="text-success">
                        <i class="bi bi-star-fill"></i> Pesanan selesai. Terima kasih telah berbelanja!
                    </small>
                </div>
            @elseif($order->status == 'cancelled')
                <div class="mt-2 p-2 bg-light rounded">
                    <small class="text-danger">
                        <i class="bi bi-x-octagon"></i> Pesanan dibatalkan.
                    </small>
                </div>
            @endif
        </div>
    </div>
    @endforeach
@else
    <div class="text-center py-5">
        <i class="bi bi-inbox fs-1 text-muted"></i>
        <h5 class="mt-3">Belum Ada Pesanan</h5>
        <p class="text-muted">Anda belum memiliki pesanan apapun.</p>
        <a href="{{ route('products.index') }}" class="btn btn-navy">
            <i class="bi bi-shop"></i> Mulai Belanja
        </a>
    </div>
@endif