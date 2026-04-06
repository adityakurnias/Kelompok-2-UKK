<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autentikasi - Fariz Net</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            background-color: #0f172a;
            background-image: radial-gradient(rgba(14,165,233,0.07) 1px, transparent 1px);
            background-size: 28px 28px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Instrument Sans', sans-serif;
            color: #f8fafc;
        }
        
        .auth-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 2rem;
        }

        .auth-card {
            background: #1e293b;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 2rem;
            box-shadow: 0 40px 80px rgba(0,0,0,0.5);
            padding: 2.5rem;
        }

        .brand-text {
            font-size: 1.75rem;
            font-weight: 900;
            font-style: italic;
            letter-spacing: -2px;
            text-transform: uppercase;
            color: #0ea5e9;
            text-decoration: none;
        }

        .form-label {
            display: block;
            font-size: 0.65rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            background: #0f172a;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 0.875rem;
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.875rem 1rem;
            outline: none;
            transition: all 0.2s;
            font-family: 'Instrument Sans', sans-serif;
        }
        .form-input:focus { border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.15); }
        .form-input::placeholder { color: #475569; }

        .btn-primary {
            width: 100%;
            background: #0ea5e9;
            color: white;
            font-weight: 900;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 1rem;
            border-radius: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Instrument Sans', sans-serif;
        }
        .btn-primary:hover { background: #38bdf8; transform: scale(1.02); box-shadow: 0 0 25px rgba(14,165,233,0.3); }

        .link-sky { color: #0ea5e9; font-weight: 700; text-decoration: none; }
        .link-sky:hover { color: #38bdf8; }
        
        .divider { border: none; border-top: 1px solid rgba(255,255,255,0.07); margin: 1.5rem 0; }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="text-center mb-8">
            <a href="/" class="brand-text">FARIZ NET</a>
            <p style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.2em; color:#475569; margin-top:0.5rem;">Network Device Store</p>
        </div>
        
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>