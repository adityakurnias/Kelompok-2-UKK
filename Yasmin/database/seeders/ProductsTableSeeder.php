<?php
// database/seeders/ProductsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'user_id' => 3,
                'category_id' => 1,
                'name' => 'Kemeja Flannel Preloved',
                'description' => 'Kemeja flannel kondisi 90%, masih bagus, layak pakai',
                'price' => 75000,
                'condition' => 'seperti_baru',
                'status' => 'tersedia',
                'image' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=800&q=80'
            ],
            [
                'user_id' => 3,
                'category_id' => 2, // Elektronik
                'name' => 'Speaker Bluetooth Portable',
                'description' => 'Speaker bekas pemakaian 6 bulan, masih berfungsi baik',
                'price' => 150000,
                'condition' => 'bekas',
                'status' => 'tersedia',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80'
            ],
            [
                'user_id' => 3,
                'category_id' => 3, // Buku
                'name' => 'Novel Laskar Pelangi',
                'description' => 'Buku bekas, masih utuh, tidak ada halaman rusak',
                'price' => 35000,
                'condition' => 'bekas',
                'status' => 'tersedia',
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=800&q=80'
            ],
            [
                'user_id' => 3,
                'category_id' => 2, // Elektronik
                'name' => 'Kamera Mirrorless Bekas',
                'description' => 'Kamera kondisi mulus, jarang dipakai, lengkap dengan box',
                'price' => 4500000,
                'condition' => 'seperti_baru',
                'status' => 'tersedia',
                'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&q=80'
            ],
            [
                'user_id' => 3,
                'category_id' => 6, // Olahraga
                'name' => 'Sepatu Lari Nike Original',
                'description' => 'Sepatu lari nyaman, sol masih tebal, minus pemakaian wajar',
                'price' => 550000,
                'condition' => 'bekas',
                'status' => 'tersedia',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80'
            ]
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}