<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Produk Baru - FurniSpace</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:400,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-light: #F9F7F2;
            --primary-wood: #78350f;
            --secondary-wood: #a16207;
            --text-main: #433422;
            --border-color: #eaddcf;
        }

        body {
            background-color: var(--bg-light);
            min-height: 100vh;
            color: var(--text-main);
            padding-top: 100px;
            font-family: 'Instrument Sans', sans-serif;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border-color);
            padding: 15px 0;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary-wood) !important;
        }

        .form-container {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 40px;
            padding: 50px;
            box-shadow: 0 20px 40px rgba(120, 53, 15, 0.03);
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary-wood);
            margin-bottom: 35px;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--secondary-wood);
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .form-control {
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(120, 53, 15, 0.08);
            border-color: var(--primary-wood);
            outline: none;
        }

        /* Checkbox Section Styling - Sama seperti menu Edit */
        .category-grid {
            background: var(--bg-light);
            border: 2px solid var(--border-color);
            border-radius: 20px;
            padding: 20px;
        }

        .custom-check-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 10px;
            transition: background 0.2s;
        }

        .custom-check-item:hover {
            background: #f0ede4;
        }

        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            cursor: pointer;
            border: 2px solid var(--border-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-wood);
            border-color: var(--primary-wood);
        }

        .form-check-label {
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .btn-custom {
            background: var(--primary-wood);
            color: white !important;
            border: none;
            border-radius: 18px;
            font-weight: 700;
            padding: 18px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-custom:hover {
            background: #451a03;
            transform: translateY(-2px);
        }

        #image-preview {
            max-width: 200px;
            border-radius: 20px;
            display: none;
            margin-top: 15px;
            border: 2px solid var(--border-color);
            padding: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fs-4" href="/">🪑 FurniSpace</a>
            <div class="ms-auto">
                <a href="{{ route('admin.products.index') }}" class="text-decoration-none fw-bold" style="color: var(--secondary-wood);">← Batal</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="form-container">
                    <h2>Tambah Koleksi Baru</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Nama Produk Furniture</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Sofa Minimalis Velvet" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Deskripsi Koleksi</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Deskripsi detail produk...">{{ old('description') }}</textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Harga Satuan (Rp)</label>
                                <input type="number" name="price" class="form-control" placeholder="0" value="{{ old('price') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stok Tersedia</label>
                                <input type="number" name="stock" class="form-control" placeholder="0" value="{{ old('stock') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Kategori Ruangan</label>
                            <div class="category-grid">
                                <div class="row">
                                    @forelse($categories as $kat)
                                        <div class="col-6 col-md-4">
                                            <div class="custom-check-item">
                                                <input class="form-check-input" type="checkbox"
                                                       name="categories[]"
                                                       value="{{ $kat->id }}"
                                                       id="cat-{{ $kat->id }}"
                                                       {{ is_array(old('categories')) && in_array($kat->id, old('categories')) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="cat-{{ $kat->id }}">
                                                    {{ $kat->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-2">
                                            <p class="text-muted small mb-0"><em>Belum ada kategori di database.</em></p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">*Anda dapat memilih lebih dari satu kategori.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Foto Produk</label>
                            <input type="file" name="image" id="image-input" class="form-control" accept="image/*" required>
                            <div class="text-center mt-3">
                                <img id="image-preview" src="#" alt="Preview">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-custom shadow-sm">Simpan Koleksi Baru</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'inline-block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
