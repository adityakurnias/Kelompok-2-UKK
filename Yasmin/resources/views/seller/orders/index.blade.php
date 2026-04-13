@extends('layouts.app')

@section('title', 'Pesanan Masuk - Seller')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-navy mb-4"><i class="bi bi-cart-check"></i> Pesanan Masuk</h2>
            
            
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. Order</th>
                                <th>Pembeli</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orderItems as $item)
                            <tr>
                                <td>{{ $item->order->order_number }}</td>
                                <td>{{ $item->order->buyer->name }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'shipped' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ][$item->order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ ucfirst($item->order->status) }}</span>
                                </td>
                                <td>
                                    @if($item->order->status == 'pending')
                                        <form action="{{ route('seller.orders.confirm', $item->order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-check"></i> Konfirmasi
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($item->order->status == 'confirmed')
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                                                data-bs-target="#shipModal{{ $item->order->id }}">
                                            <i class="bi bi-truck"></i> Kirim
                                        </button>
                                    @endif
                                    
                                    <a href="#" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            
                            {{-- Ship Modal --}}
                            <div class="modal fade" id="shipModal{{ $item->order->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('seller.orders.ship', $item->order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Update Pengiriman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Kurir</label>
                                                    <input type="text" name="courier" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No. Resi</label>
                                                    <input type="text" name="tracking_number" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="mt-2">Belum ada pesanan masuk</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 d-flex justify-content-center">
                    {{ $orderItems->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection