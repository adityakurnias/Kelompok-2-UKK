<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Perangkat Baru - Fariz Net Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
        background-color: #1a1c23; 
        min-height: 100vh; 
        color: #f3f4f6; 
        padding-top: 100px;
        font-family: 'Inter', sans-serif;
        }

        .navbar { 
            background: #000000 !important; 
            border-bottom: 4px solid #374151;
            padding: 15px 0;
        }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-style: italic; text-transform: uppercase; }

        .form-container {
            background: #ffffff; 
            color: #111827;
            border: 4px solid #000000;
            border-radius: 0px;
            padding: 40px; 
            box-shadow: 15px 15px 0px 0px #374151;
        }

        h2 { font-weight: 900; text-transform: uppercase; letter-spacing: -1px; border-bottom: 5px solid #111827; display: inline-block; margin-bottom: 30px; }

        .form-label { font-weight: 800; text-transform: uppercase; font-size: 0.8rem; color: #111827; letter-spacing: 1px; }

        .form-control { 
            background: #f9fafb; 
            border: 2px solid #111827; 
            color: #111827 !important; 
            border-radius: 0px;
            font-weight: 600;
            padding: 12px;
        }
        .form-control:focus { 
            background: #ffffff; 
            box-shadow: none; 
            border: 2px solid #6b7280; 
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0px 0px #111827;
        }
        .form-control::placeholder { color: #9ca3af; }

        .btn-custom { 
            background: #111827; 
            color: white !important; 
            border: none; 
            border-radius: 0px;
            font-weight: 900; 
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 15px;
            transition: all 0.2s;
            box-shadow: 6px 6px 0px 0px #9ca3af;
        }
        .btn-custom:hover { 
            background: #000000; 
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px 0px #9ca3af;
        }

        .btn-back {
            color: #9ca3af;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            text-decoration: none;
            transition: color 0.3s;
        }
        .btn-back:hover { color: white; }

        #image-preview { 
            max-width: 100%; 
            max-height: 250px; 
            border-radius: 0px; 
            display: none; 
            margin-top: 15px; 
            border: 4px solid #111827;
            padding: 5px;
            background: white;
        }

        .alert-danger {
            background: #fee2e2;
            border: 3px solid #ef4444;
            color: #b91c1c;
            border-radius: 0px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">FARIZ NET STORE</a>
            <div class="ms-auto d-flex align-items-center">
                <a href="{{ route('admin.products.index') }}" class="btn-back me-4">← Kembali</a>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary fw-black uppercase px-3" style="font-size: 10px; font-weight: 900; border-width: 2px;">LOGOUT</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="form-container mb-5">
                    <h2>TAMBAHKAN PERANGKAT BARU</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger shadow-[5px_5px_0px_0px_rgba(239,68,68,1)]">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category_id" value="1">

                        <div class="mb-4">
                            <label class="form-label">Nama Perangkat</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Modem Wifi TP-Link" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Harga Retail (Rp)</label>
                                <input type="number" name="price" class="form-control" placeholder="0" value="{{ old('price') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stok Gudang</label>
                                <input type="number" name="stock" class="form-control" placeholder="0" value="{{ old('stock') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Foto Produk</label>
                            <input type="file" name="image" id="image-input" class="form-control" accept="image/*">
                            <div class="mt-3 text-center">
                                <img id="image-preview" src="#" alt="Preview Gambar">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-custom">Simpan ke Katalog</button>
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
            } else {
                imagePreview.style.display = 'none';
            }
        });
    </script>
</body>
</html>