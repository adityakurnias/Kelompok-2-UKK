<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourcePath = database_path('seeders/images/products');
        $destinationPath = storage_path('app/public/products');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Mapping produk langsung ke nama gambar dan kategorinya
        $products = [
            ['name' => 'Amplifier', 'file' => 'Amplifier.webp', 'cat' => 'alat-musik', 'price' => 2000000],
            ['name' => 'Biola', 'file' => 'Biola.jpg', 'cat' => 'alat-musik', 'price' => 1500000],
            ['name' => 'Drum', 'file' => 'Drum.jpg', 'cat' => 'alat-musik', 'price' => 5000000],
            ['name' => 'Gantungan Baju dan Rak', 'file' => 'Gantungan Baju dan Rak.webp', 'cat' => 'kamar-tidur', 'price' => 350000],
            ['name' => 'Gitar Coklat', 'file' => 'Gitar Coklat.jpg', 'cat' => 'alat-musik', 'price' => 1200000],
            ['name' => 'Gitar Listrik Merah', 'file' => 'Gitar Listrik Merah.webp', 'cat' => 'alat-musik', 'price' => 2500000],
            ['name' => 'Gitar Listrik', 'file' => 'Gitar Listrik.webp', 'cat' => 'alat-musik', 'price' => 2200000],
            ['name' => 'Gitar', 'file' => 'Gitar.webp', 'cat' => 'alat-musik', 'price' => 1000000],
            ['name' => 'Hiasan Dinding', 'file' => 'Hiasan Dinding.webp', 'cat' => 'dekorasi', 'price' => 150000],
            ['name' => 'Horden', 'file' => 'Horden.webp', 'cat' => 'dekorasi', 'price' => 200000],
            ['name' => 'Jam', 'file' => 'Jam.webp', 'cat' => 'dekorasi', 'price' => 120000],
            ['name' => 'Kaca', 'file' => 'Kaca.webp', 'cat' => 'dekorasi', 'price' => 250000],
            ['name' => 'Karpet Coklat', 'file' => 'Karpet Coklat.webp', 'cat' => 'ruang-keluarga', 'price' => 450000],
            ['name' => 'Karpet', 'file' => 'Karpet.webp', 'cat' => 'ruang-keluarga', 'price' => 400000],
            ['name' => 'Kasur Single', 'file' => 'Kasur Single.webp', 'cat' => 'kamar-tidur', 'price' => 1500000],
            ['name' => 'Kasur', 'file' => 'Kasur.webp', 'cat' => 'kamar-tidur', 'price' => 2500000],
            ['name' => 'Piano', 'file' => 'Piano.jpg', 'cat' => 'alat-musik', 'price' => 15000000],
            ['name' => 'Product 15', 'file' => 'product_15.jpg', 'cat' => 'lain-lain', 'price' => 100000],
            ['name' => 'Product 16', 'file' => 'product_16.jpg', 'cat' => 'lain-lain', 'price' => 100000],
            ['name' => 'Sofa', 'file' => 'Sofa.jpg', 'cat' => 'ruang-keluarga', 'price' => 3500000],
        ];

        foreach ($products as $item) {
            $sourceFile = $sourcePath . '/' . $item['file'];
            $destFile = $destinationPath . '/' . $item['file'];

            // Salin file jika ada di folder source
            if (file_exists($sourceFile)) {
                copy($sourceFile, $destFile);
            }

            // Buat record Product
            $product = Product::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'stock' => rand(5, 50),
                'image' => 'products/' . $item['file'],
                'description' => 'Deskripsi untuk ' . $item['name'] . '. Produk berkualitas tinggi untuk melengkapi kebutuhan Anda.',
            ]);

            // Hubungkan ke kategori yang tepat
            $category = Category::where('slug', $item['cat'])->first();
            if ($category) {
                $product->categories()->attach($category->id);
            }
        }
    }
}