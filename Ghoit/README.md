# ATK Premium E-Commerce Stationaries

Platform e-commerce single-seller minimalis dan mewah yang dibangun dengan **Laravel 12** and **Tailwind CSS**. Proyek ini menawarkan pengalaman belanja alat tulis kantor yang mulus dengan fokus pada estetika premium dan kontrol administratif yang mudah.

## 🚀 Memulai Cepat & Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di mesin lokal Anda:

### 1. Persyaratan Sistem
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/SQLite

### 2. Instruksi Setup
```bash
# Masuk ke direktori proyek
cd atk-ecommerce

# Instal dependensi PHP
composer install

# Instal dependensi Frontend
npm install

# Buat file environment
cp .env.example .env

# Generate application key
php artisan key:generate

# Jalankan Migrasi dan Seed data awal (Admin & Produk)
php artisan migrate:fresh --seed

# Hubungkan storage untuk gambar produk
php artisan storage:link

# Jalankan server pengembangan
php artisan serve

# Di terminal terpisah, jalankan asset compiler
npm run dev
```

### 3. Akses Situs
Buka browser Anda dan akses: `http://127.0.0.1:8000`

---

## 🔐 Kredensial Login

Gunakan akun berikut yang sudah tersedia di database untuk menguji peran yang berbeda:

### 👤 Akun Admin (Akses Manajemen)
- **Email:** `admin@atk.com`
- **Password:** `password`
*Admin dapat mengelola produk, kategori, serta melihat dan menyetujui transaksi pengguna.*

### 🛒 Akun Pembeli (Akses Belanja)
- **Email:** `buyer@atk.com`
- **Password:** `password`
*Pembeli dapat menambahkan barang ke keranjang, melakukan checkout, dan melacak riwayat pesanan.*

---

## ✨ Fitur Utama
- **Storefront Modern**: Daftar produk dinamis dengan filter kategori dan pencarian.
- **Keranjang Belanja**: Keranjang belanja berbasis sesi dengan antarmuka minimalis.
- **Sistem Checkout**: Pengambilan biodata pelanggan untuk konfirmasi pembayaran manual.
- **Dashboard Admin**: Metrik penjualan real-time dan pemantauan stok barang.
- **Pelacakan Pesanan**: Update status transaksi interaktif untuk pelanggan.

---
*Dibuat dengan ❤️ menggunakan Laravel 12 & Tailwind CSS.*
