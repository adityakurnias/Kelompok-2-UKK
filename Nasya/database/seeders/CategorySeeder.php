<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // Pastikan model Category sudah ada
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kamar Tidur', 'icon' => '🛏️'],
            ['name' => 'Ruang Keluarga', 'icon' => '🛋️'],
            ['name' => 'Dapur', 'icon' => '🍳'],
            ['name' => 'Ruang Makan', 'icon' => '🍽️'],
            ['name' => 'Ruang Kerja', 'icon' => '💻'],
            ['name' => 'Kamar Mandi', 'icon' => '🚿'],
            ['name' => 'Dunia Anak', 'icon' => '🧸'],
            ['name' => 'Luar Ruang', 'icon' => '🌳'],
            ['name' => 'Laundry', 'icon' => '🧺'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    // Jika Anda punya kolom icon di database, aktifkan baris bawah:
                    // 'icon' => $category['icon'],
                ]
            );
        }
    }
}
