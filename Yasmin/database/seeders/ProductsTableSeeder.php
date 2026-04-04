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
                'user_id' => 3, // Ani Penjual
                'category_id' => 1, // Pakaian
                'name' => 'Kemeja Flannel Preloved',
                'description' => 'Kemeja flannel kondisi 90%, masih bagus, layak pakai',
                'price' => 75000,
                'condition' => 'seperti_baru',
                'status' => 'tersedia',
                'image' => 'kemeja-flannel.jpg'
            ],
            [
                'user_id' => 3,
                'category_id' => 2, // Elektronik
                'name' => 'Speaker Bluetooth Portable',
                'description' => 'Speaker bekas pemakaian 6 bulan, masih berfungsi baik',
                'price' => 150000,
                'condition' => 'bekas',
                'status' => 'tersedia',
                'image' => 'speaker.jpg'
            ],
            [
                'user_id' => 3,
                'category_id' => 3, // Buku
                'name' => 'Novel Laskar Pelangi',
                'description' => 'Buku bekas, masih utuh, tidak ada halaman rusak',
                'price' => 35000,
                'condition' => 'bekas',
                'status' => 'tersedia',
                'image' => 'novel.jpg'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}