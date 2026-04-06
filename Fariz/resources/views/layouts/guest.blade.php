<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Authentikasi - Feroz Net Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            /* Background Abu Industrial Gelap */
            background: #1f2937; 
            background-image: radial-gradient(#374151 1px, transparent 1px);
            background-size: 20px 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        
        .auth-card {
            background: #ffffff;
            /* Border Tebal & Kaku khas Industrial */
            border: 4px solid #000000;
            border-radius: 0px; /* Siku kotak lebih industrial */
            box-shadow: 12px 12px 0px 0px rgba(0,0,0,1); /* Hard Shadow */
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }

        .btn-custom { 
            background: #111827; /* Hitam Pekat */
            color: white !important; 
            border: none; 
            border-radius: 0px;
            font-weight: 900; 
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 12px;
            transition: all 0.2s;
            border-bottom: 4px solid #4b5563;
        }

        .btn-custom:hover { 
            background: #000000;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0px 0px #4b5563;
        }

        /* Styling Input agar selaras */
        input.form-control {
            border: 2px solid #111827;
            border-radius: 0px;
            font-weight: 600;
        }

        input.form-control:focus {
            box-shadow: none;
            border-color: #6b7280;
        }

        .brand-text {
            font-size: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-5">
            <a href="/" class="text-decoration-none brand-text text-dark underline decoration-4 decoration-gray-400">
                FEROZ NET STORE
            </a>
            <div class="text-[10px] font-bold text-gray-400 mt-1 tracking-[.3em]"></div>
        </div>
        
        <div class="auth-content">
            {{ $slot }}
        </div>
    </div>
</body>
</html>