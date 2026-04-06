@extends('layouts.admin')

@section('title', 'Kelola Kategori - Admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-navy mb-4">
                <i class="bi bi-tags"></i> Kelola Kategori
            </h2>
            
            <!-- Form Tambah Kategori -->
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                <div class="card-header bg-navy text-white py-3">
                    <h5 class="mb-0" style="font-family:'Playfair Display',serif; font-weight:700;">Tambah Kategori Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="row g-3 items-end">
                            <div class="col-12 col-md-9">
                                <label class="form-label font-size-sm fw-bold text-muted text-uppercase mb-2" style="letter-spacing:1px; font-size:0.7rem;">Nama Kategori</label>
                                <input type="text" name="name" class="form-control form-control-lg" 
                                       placeholder="Misal: Pakaian Pria" style="border-radius:10px; font-size:0.9rem; border:1.5px solid #eee;" required>
                            </div>
                            <div class="col-12 col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-navy btn-lg w-100" style="border-radius:10px; font-size:0.9rem; padding: 0.7rem;">
                                    <i class="bi bi-plus-lg"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Daftar Kategori -->
            <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Slug</th>
                                <th>Jumlah Produk</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $category->products_count }} produk</span>
                                </td>
                                <td>{{ $category->created_at->format('d M Y') }}</td>
                                <td>
                                    <!-- Edit Button (Trigger Modal) -->
                                    <button class="btn btn-sm btn-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal{{ $category->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    
                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.categories.delete', $category) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Hapus kategori {{ $category->name }}?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header bg-navy text-white">
                                                <h5 class="modal-title">Edit Kategori</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Nama Kategori</label>
                                                    <input type="text" name="name" class="form-control" 
                                                           value="{{ $category->name }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-navy">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-folder-x fs-1"></i>
                                    <p class="mt-2">Belum ada kategori</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection