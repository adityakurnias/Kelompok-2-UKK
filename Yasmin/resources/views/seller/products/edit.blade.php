@extends('layouts.app')

@section('title', 'Edit Produk - Seller')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-navy text-white">
                    <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Produk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $product->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price', $product->price) }}" required>
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                                <select name="condition" class="form-select @error('condition') is-invalid @enderror" required>
                                    <option value="baru" {{ $product->condition == 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="seperti_baru" {{ $product->condition == 'seperti_baru' ? 'selected' : '' }}>Seperti Baru</option>
                                    <option value="bekas" {{ $product->condition == 'bekas' ? 'selected' : '' }}>Bekas</option>
                                </select>
                                @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Foto Produk Saat Ini</label>
                            <div>
                                <img src="{{ $product->image_url }}" 
                                     width="100" height="100" style="object-fit: cover;">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Ganti Foto (Opsional)</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-3">
                            <a href="{{ route('seller.products') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-navy px-4 py-2">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection