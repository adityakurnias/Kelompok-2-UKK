<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Authentikasi - FURNISPACE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            /* Warna Background Cream Hangat */
            background-color: #F9F7F2;
            background-image: url("https://www.transparenttextures.com/patterns/natural-paper.png");
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            color: #433422;
        }

        .auth-card {
            background: #ffffff;
            /* Border halus dengan bayangan lembut */
            border: 1px solid #eaddcf;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(67, 52, 34, 0.05);
            width: 100%;
            max-width: 440px;
            padding: 50px 40px;
            position: relative;
            overflow: hidden;
        }

        /* Aksen kayu kecil di bagian atas kartu */
        .auth-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: #78350f; /* Warna Amber/Kayu Gelap */
        }

        .brand-text {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #78350f;
            letter-spacing: -0.5px;
            margin-bottom: 5px;
            display: block;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #a89379;
            font-weight: 600;
        }

        /* Input Styling */
        input.form-control {
            border: 1.5px solid #eaddcf;
            border-radius: 12px;
            padding: 12px 16px;
            background-color: #fdfcfb;
            transition: all 0.3s ease;
        }

        input.form-control:focus {
            box-shadow: 0 0 0 4px rgba(120, 53, 15, 0.1);
            border-color: #78350f;
            background-color: #fff;
        }

        /* Button Styling */
        .btn-custom {
            background: #78350f; /* Warna Kayu Gelap */
            color: #ffffff !important;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-transform: none;
            padding: 14px;
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .btn-custom:hover {
            background: #451a03;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(120, 53, 15, 0.2);
        }

        .auth-content label {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 8px;
            color: #5d4a36;
        }

        /* Link Styling */
        .auth-content a {
            color: #78350f;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .auth-content a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-5">
            <a href="/" class="text-decoration-none">
                <span class="brand-text">FurniSpace</span>
            </a>
            <div class="brand-subtitle">Elegance in Every Corner</div>
        </div>

        <div class="auth-content">
            {{ $slot }}
        </div>

        <div class="text-center mt-5">
            <p class="text-muted" style="font-size: 0.75rem;">&copy; 2026 FurniSpace Workshop. <br>Crafting Quality Comfort.</p>
        </div>
    </div>
</body>
</html>
