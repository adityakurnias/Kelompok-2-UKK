<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $laptop->model }} | Details & Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .lenovo-red { color: #E2231A; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <nav class="bg-black text-white px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-extrabold tracking-tighter uppercase">
                BUITENZORG <span class="lenovo-red">TECH</span>SPERTS
            </h1>
            
            <div class="flex items-center space-x-6">
                <div class="flex items-center bg-gray-900 border border-gray-700 rounded-md px-2 py-1 text-[10px] font-bold uppercase tracking-widest">
                    <button onclick="setLanguage('en')" id="btn-en" class="text-red-500 hover:text-red-400 px-1 transition">EN</button>
                    <span class="text-gray-600 px-1">|</span>
                    <button onclick="setLanguage('id')" id="btn-id" class="text-gray-400 hover:text-white px-1 transition">ID</button>
                </div>
                
                <a href="{{ route('catalogue') }}" 
                   class="lang-target text-xs font-bold uppercase tracking-widest hover:text-red-500 transition"
                   data-en="Back to Catalogue" data-id="Kembali ke Katalog">
                    Back to Catalogue
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto py-12 px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-10 shadow-sm border border-gray-200">
            
            <div>
                <div class="bg-white border border-gray-100 rounded-lg p-2 mb-6 shadow-sm">
                    <img src="{{ asset($laptop->image) }}" 
                         alt="{{ $laptop->model }}" 
                         class="w-full h-auto object-contain max-h-[400px]">
                </div>
                
                <h2 class="text-3xl font-black text-gray-900 mb-2 uppercase">{{ $laptop->model }}</h2>
                <p class="text-2xl font-bold lenovo-red mb-6">Rp {{ number_format($laptop->price, 0, ',', '.') }}</p>
                
                <div class="space-y-4 border-t pt-6 text-gray-600 text-sm">
                    <p class="flex justify-between">
                        <strong class="lang-target" data-en="Processor:" data-id="Prosesor:">Processor:</strong> 
                        <span>{{ $laptop->processor }}</span>
                    </p>
                    <p class="flex justify-between">
                        <strong class="lang-target" data-en="Memory:" data-id="Memori (RAM):">Memory:</strong> 
                        <span>{{ $laptop->ram }}</span>
                    </p>
                    <p class="flex justify-between">
                        <strong class="lang-target" data-en="Storage:" data-id="Penyimpanan:">Storage:</strong> 
                        <span>{{ $laptop->storage }}</span>
                    </p>
                </div>

                <div class="mt-8">
                    <h3 class="lang-target text-xs font-bold uppercase tracking-[0.2em] text-gray-400 mb-4" 
                        data-en="Product Description" data-id="Deskripsi Produk">
                        Product Description
                    </h3>
                    <p class="text-gray-700 leading-relaxed italic text-sm">
                        {{ $laptop->description ?? 'Thinkpad core quality. Heavy duty performance.' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col bg-gray-50 p-6 border-l">
                <form action="{{ route('order.store', $laptop->id) }}" method="POST">
                    @csrf
                    <h3 class="lang-target text-xs font-bold uppercase tracking-[0.2em] text-gray-900 mb-6"
                        data-en="Order Details" data-id="Detail Pesanan">
                        Order Details
                    </h3>

                    <div class="mb-4">
                        <label class="lang-target block text-[10px] font-black uppercase text-gray-400 mb-1" 
                               data-en="Quantity" data-id="Jumlah Pesanan">Quantity</label>
                        <input type="number" name="quantity" value="1" min="1" required
                               class="w-full border-2 border-gray-200 p-3 font-bold focus:border-black outline-none transition">
                    </div>

                    <div class="mb-6">
                        <label class="lang-target block text-[10px] font-black uppercase text-gray-400 mb-1" 
                               data-en="Shipping Address" data-id="Alamat Pengiriman">Shipping Address</label>
                        <textarea name="alamat" rows="3" required placeholder="Full Address / Alamat Lengkap..."
                                  class="w-full border-2 border-gray-200 p-3 text-sm focus:border-black outline-none transition"></textarea>
                    </div>

                    <h3 class="lang-target text-xs font-bold uppercase tracking-[0.2em] text-gray-900 mb-4"
                        data-en="Select Payment & Place Order" data-id="Pilih Pembayaran & Pesan">
                        Select Payment & Place Order
                    </h3>
                    
                    <div class="space-y-3">
                        <button type="submit" name="payment_method" value="Bank Transfer"
                                class="w-full flex items-center justify-between p-3 bg-white border-2 border-gray-200 hover:border-red-600 transition group">
                            <span class="lang-target text-[10px] font-bold uppercase" data-en="Bank Transfer" data-id="Transfer Bank">Bank Transfer</span>
                            <div class="flex space-x-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" class="h-3">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/BRI_2020.svg/1200px-BRI_2020.svg.png" class="h-3">
                            </div>
                        </button>

                        <button type="submit" name="payment_method" value="E-Wallet"
                                class="lang-target w-full bg-blue-600 text-white font-bold uppercase text-[10px] tracking-widest py-4 shadow-lg hover:bg-black transition"
                                data-en="Pay with E-Wallet (QRIS/Gopay/OVO)" data-id="Bayar dengan E-Wallet (QRIS/Gopay/OVO)">
                            Pay with E-Wallet (QRIS/Gopay/OVO)
                        </button>

                        <button type="submit" name="payment_method" value="COD"
                                class="lang-target w-full border-2 border-gray-900 text-gray-900 font-bold uppercase text-[10px] tracking-widest py-3 hover:bg-gray-900 hover:text-white transition"
                                data-en="Cash on Delivery (COD)" data-id="Bayar di Tempat (COD)">
                            Cash on Delivery (COD)
                        </button>
                    </div>
                </form>

                <p class="lang-target text-[9px] text-gray-400 mt-8 text-center uppercase tracking-widest"
                   data-en="Buitenzorg TechSperts Transaction Portal" data-id="Portal Transaksi Buitenzorg TechSperts">
                    Buitenzorg TechSperts Transaction Portal
                </p>
            </div>
        </div>
    </main>

    <script>
        function setLanguage(lang) {
            const targets = document.querySelectorAll('.lang-target');
            targets.forEach(el => {
                const translation = el.getAttribute(`data-${lang}`);
                if (translation) {
                    el.innerText = translation;
                }
            });

            const btnEn = document.getElementById('btn-en');
            const btnId = document.getElementById('btn-id');

            if (lang === 'en') {
                btnEn.classList.replace('text-gray-400', 'text-red-500');
                btnId.classList.replace('text-red-500', 'text-gray-400');
            } else {
                btnId.classList.replace('text-gray-400', 'text-red-500');
                btnEn.classList.replace('text-red-500', 'text-gray-400');
            }
        }
    </script>
</body>
</html>