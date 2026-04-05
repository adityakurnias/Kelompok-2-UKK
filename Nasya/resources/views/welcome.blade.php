<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - FurniSpace</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-light: #F9F7F2;      /* Cream Soft */
            --primary-wood: #78350f;  /* Amber/Wood Dark */
            --secondary-wood: #a16207;/* Wood Medium */
            --accent-warm: #fef3c7;   /* Amber Light */
            --text-main: #433422;     /* Brown Dark */
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-main);
            font-family: 'Instrument Sans', sans-serif;
            min-height: 100vh;
            padding-top: 80px;
        }

        .navbar {
            background: rgba(249, 247, 242, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #eaddcf;
            box-shadow: 0 4px 20px rgba(67, 52, 34, 0.05);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--primary-wood) !important;
        }

        .nav-link {
            color: var(--text-main) !important;
            font-weight: 600;
        }

        .hero-section {
            background: linear-gradient(rgba(67, 52, 34, 0.6), rgba(67, 52, 34, 0.6)),
                        url('https://jejakpiknik.com/wp-content/uploads/2021/08/toko-furniture-kayu-jati-di-jakarta-selatan.jpg');
            background-size: cover;
            background-position: center;
            border-radius: 40px;
            border: none;
            margin-top: 20px;
            padding: 100px 20px;
        }

        .hero-section h1 {
            font-family: 'Playfair Display', serif;
            text-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .hero-section p.lead {
            color: #ffffff !important;
            font-weight: 400;
            max-width: 700px;
            margin: 0 auto;
        }

        .feature-box {
            background: #ffffff;
            border-radius: 30px;
            border: 1px solid #eaddcf;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .feature-box h4 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-wood);
        }

        .feature-box p.text-muted {
            color: #7d6e5d !important;
            font-size: 0.95rem;
        }

        .feature-box:hover {
            transform: translateY(-12px);
            border-color: var(--secondary-wood);
            box-shadow: 0 20px 40px rgba(120, 53, 15, 0.1);
        }

        .card-section {
            background: var(--primary-wood);
            border-radius: 40px;
            border: none;
            color: #fff;
        }

        .btn-custom {
            background: var(--primary-wood);
            color: #ffffff !important;
            border: none;
            font-weight: 600;
            border-radius: 14px;
            padding: 12px 28px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: #451a03;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(120, 53, 15, 0.2);
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-wood);
            color: var(--primary-wood) !important;
            font-weight: 600;
            border-radius: 14px;
        }

        .btn-outline-custom:hover {
            background: var(--primary-wood);
            color: #fff !important;
        }

        .accent-text { color: var(--accent-warm); }

        footer {
            background: #fff;
            color: var(--text-main);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                FurniSpace
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('products.index') }}">Katalog</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-custom ms-lg-3">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="btn btn-sm btn-custom ms-lg-3 px-4" href="{{ route('register') }}">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="hero-section p-5 text-center mb-5 shadow-sm">
            <h1 class="display-3 fw-bold text-white mb-3">Elegansi <span class="accent-text italic">Ruang Hunian</span></h1>
            <p class="lead mb-4 fs-5 opacity-90">Kurasi furniture premium yang menggabungkan kenyamanan tak tertandingi dengan keahlian kayu terbaik untuk rumah impian Anda.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#koleksi" class="btn btn-lg btn-custom px-5">Lihat Koleksi</a>
            </div>
        </div>

        <div class="row g-4 mb-5 text-center" id="koleksi">
            <div class="col-md-4">
                <div class="feature-box p-5 h-100 shadow-sm">
                    <div class="fs-1 mb-3">🪑</div>
                    <h4 class="fw-bold mb-3">Desain Berkelas</h4>
                    <p class="text-muted">Setiap koleksi dirancang dengan detail presisi, memadukan estetika modern dan fungsionalitas untuk keindahan ruang Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box p-5 h-100 shadow-sm">
                    <div class="fs-1 mb-3">🪵</div>
                    <h4 class="fw-bold mb-3">Material Terpilih</h4>
                    <p class="text-muted">Menggunakan kayu solid dan kain premium yang tahan lama, menghadirkan sentuhan mewah yang tetap kokoh bertahun-tahun.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box p-5 h-100 shadow-sm">
                    <div class="fs-1 mb-3">✨</div>
                    <h4 class="fw-bold mb-3">Layanan Ahli</h4>
                    <p class="text-muted">Dari konsultasi desain hingga pemasangan di rumah, tim profesional kami memastikan setiap detail terpasang dengan sempurna.</p>
                </div>
            </div>
        </div>

        <div class="card-section p-5 mb-5 shadow-lg">
            <div class="row text-center align-items-center">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h3 class="display-4 fw-bold accent-text">{{ \App\Models\Product::count() }}</h3>
                    <p class="text-uppercase small tracking-widest fw-bold opacity-75">Koleksi Produk</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0 border-start border-end border-white border-opacity-25">
                    <h3 class="display-4 fw-bold accent-text">{{ \App\Models\User::count() }}</h3>
                    <p class="text-uppercase small tracking-widest fw-bold opacity-75">Pelanggan Puas</p>
                </div>
                <div class="col-md-4">
                    <h3 class="display-4 fw-bold accent-text">4.9/5</h3>
                    <p class="text-uppercase small tracking-widest fw-bold opacity-75">Rating Showroom</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-5 border-top mt-5">
        <div class="container text-center">
            <div class="mb-3">
                <span class="navbar-brand fw-bold">FurniSpace</span>
            </div>
            <p class="text-muted small mb-0">&copy; 2026 Crafted with Passion by Nasya Putri</p>
            <p class="text-muted extra-small">Kenyamanan Premium untuk Setiap Sudut Rumah.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
