<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Perangkat - Feroz Net</title>
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
            border-bottom: 4px solid #333a45;
            padding: 15px 0;
        }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-style: italic; text-transform: uppercase; }

        .form-container {
            background: #ffffff; 
            color: #111827;
            border: 4px solid #000000;
            border-radius: 0px; 
            padding: 40px; 
            box-shadow: 12px 12px 0px 0px #000000; 
        }

        h2 { 
            font-weight: 900; 
            text-transform: uppercase; 
            letter-spacing: -1px; 
            border-bottom: 5px solid #111827; 
            display: inline-block; 
            margin-bottom: 30px; 
            color: #111827;
        }

        .form-label { 
            font-weight: 800; 
            text-transform: uppercase; 
            font-size: 0.8rem; 
            color: #111827; 
            letter-spacing: 1px; 
        }

        .form-control { 
            background: #f3f4f6; 
            border: 2px solid #111827; 
            color: #111827 !important; 
            border-radius: 0px;
            font-weight: 600;
            padding: 12px;
        }

        .form-control:focus { 
            background: #ffffff; 
            box-shadow: none; 
            border: 3px solid #000000; 
            outline: none;
        }

        .btn-custom { 
            background: #000000; 
            color: white !important; 
            border: none; 
            border-radius: 0px;
            font-weight: 900; 
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 15px;
            transition: all 0.1s;
        }

        .btn-custom:hover { 
            background: #374151; 
            transform: translate(3px, 3px);
            box-shadow: -3px -3px 0px 0px #000000;
        }

        .btn-batal {
            color: #111827;
            text-decoration: none;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        .btn-batal:hover { color: #dc3545; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">FEROZ NET STORE</a>
            <div class="ms-auto d-flex align-items-center">
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="btn btn-sm btn-outline-light fw-bold rounded-0">LOGOUT</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>EDIT PERANGKAT</h2>
                        <a href="{{ route('products.index') }}" class="btn-batal">Batal</a>
                    </div>
                    
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Perangkat</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-custom py-2">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>