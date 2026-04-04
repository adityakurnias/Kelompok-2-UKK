<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@atk.com'],
            [
                'name' => 'Admin ATK',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Categories
        $categories = [
            'Alat Tulis' => [
                ['name' => 'Pulpen Gel Zebra Sarasa 0.5', 'price' => 15000, 'desc' => 'Pulpen gel kualitas premium, tinta cepat kering dan warna pekat.'],
                ['name' => 'Pensil Faber-Castell 2B', 'price' => 5000, 'desc' => 'Pensil grafit standar untuk ujian, mudah dihapus dan tidak mudah patah.'],
                ['name' => 'Highlighter Boss Original', 'price' => 12000, 'desc' => 'Penanda teks dengan warna cerah dan tahan lama.'],
            ],
            'Kertas & Buku' => [
                ['name' => 'Buku Tulis Sidu 38 Lembar', 'price' => 35000, 'desc' => 'Satu pak buku tulis isi 10 buku dengan kertas putih berkualitas.'],
                ['name' => 'Kertas HVS A4 80gr PaperOne', 'price' => 55000, 'desc' => 'Kertas printer premium, hasil cetak tajam dan tidak macet.'],
                ['name' => 'Binder Note A5 Estetik', 'price' => 45000, 'desc' => 'Buku catatan binder dengan desain minimalis untuk pelajar.'],
            ],
            'Peralatan Kantor' => [
                ['name' => 'Stapler Joyko HD-10', 'price' => 8500, 'desc' => 'Stapler standar kantor, kuat dan tahan lama.'],
                ['name' => 'Gunting Joyko Besar', 'price' => 18000, 'desc' => 'Gunting tajam dengan pegangan ergonomis.'],
                ['name' => 'Kalkulator Casio DJ-120D', 'price' => 125000, 'desc' => 'Kalkulator 12 digit dengan fitur check & correct.'],
            ],
            'Seni & Lukis' => [
                ['name' => 'Crayon Titi 24 Warna', 'price' => 45000, 'desc' => 'Krayon lembut, warna cerah, dan aman untuk anak.'],
                ['name' => 'Cat Air Reeves 12 Set', 'price' => 85000, 'desc' => 'Set cat air profesional dengan pigmentasi tinggi.'],
            ],
        ];

        foreach ($categories as $catName => $products) {
            $category = \App\Models\Category::firstOrCreate(['name' => $catName]);

            foreach ($products as $prod) {
                \App\Models\Product::updateOrCreate(
                    ['name' => $prod['name']],
                    [
                        'category_id' => $category->id,
                        'description' => $prod['desc'],
                        'price' => $prod['price'],
                        'stock' => rand(20, 100),
                        'image' => null,
                    ]
                );
            }
        }
    }
}
