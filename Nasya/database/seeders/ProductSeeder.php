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
            ['name' => 'Amplifier', 'file' => 'Amplifier.webp', 'cat' => 'alat-musik', 'price' => 2000000, 'desc' => 'Amplifier bertenaga tinggi untuk menghasilkan suara instrumen yang jernih dan menggelegar.'],
            ['name' => 'Biola', 'file' => 'Biola.jpg', 'cat' => 'alat-musik', 'price' => 1500000, 'desc' => 'Biola kayu klasik dengan resonansi suara yang indah, cocok untuk pemula dan profesional.'],
            ['name' => 'Drum', 'file' => 'Drum.jpg', 'cat' => 'alat-musik', 'price' => 5000000, 'desc' => 'Set drum akustik lengkap dengan cymbal berkualitas untuk performa ritme bertenaga.'],
            ['name' => 'Gantungan Baju dan Rak', 'file' => 'Gantungan Baju dan Rak.webp', 'cat' => 'kamar-tidur', 'price' => 350000, 'desc' => 'Rak dan gantungan baju minimalis serbaguna dari bahan kayu kuat untuk kerapian ruangan Anda.'],
            ['name' => 'Gitar Coklat', 'file' => 'Gitar Coklat.jpg', 'cat' => 'alat-musik', 'price' => 1200000, 'desc' => 'Gitar akustik berbahan kayu mahoni dengan warna coklat elegan dan senar yang nyaman ditekan.'],
            ['name' => 'Gitar Listrik Merah', 'file' => 'Gitar Listrik Merah.webp', 'cat' => 'alat-musik', 'price' => 2500000, 'desc' => 'Gitar listrik berwarna merah berani dengan pickup tajam, pas untuk genre rock dan metal.'],
            ['name' => 'Gitar Listrik', 'file' => 'Gitar Listrik.webp', 'cat' => 'alat-musik', 'price' => 2200000, 'desc' => 'Gitar elektrik serbaguna dengan neck yang presisi, dirancang untuk kenyamanan bermain maksimal.'],
            ['name' => 'Gitar', 'file' => 'Gitar.webp', 'cat' => 'alat-musik', 'price' => 1000000, 'desc' => 'Gitar akustik standar yang ideal untuk berlatih atau bersantai membawakan lagu favorit.'],
            ['name' => 'Hiasan Dinding', 'file' => 'Hiasan Dinding.webp', 'cat' => 'dekorasi', 'price' => 150000, 'desc' => 'Dekorasi estetik untuk mempercantik dinding ruang tamu atau kamar Anda dengan sentuhan artistik.'],
            ['name' => 'Horden', 'file' => 'Horden.webp', 'cat' => 'dekorasi', 'price' => 200000, 'desc' => 'Tirai berbahan tebal dan lembut, menjaga privasi ruangan sambil menambah nilai estetika interior.'],
            ['name' => 'Jam', 'file' => 'Jam.webp', 'cat' => 'dekorasi', 'price' => 120000, 'desc' => 'Jam dinding minimalis elegan yang berfungsi ganda sebagai penunjuk waktu dan hiasan menawan.'],
            ['name' => 'Kaca', 'file' => 'Kaca.webp', 'cat' => 'dekorasi', 'price' => 250000, 'desc' => 'Cermin dengan bingkai bergaya modern yang memberi kesan ruangan tampak lebih luas.'],
            ['name' => 'Karpet Coklat', 'file' => 'Karpet Coklat.webp', 'cat' => 'ruang-keluarga', 'price' => 450000, 'desc' => 'Karpet bulu halus berwarna coklat hangat yang memberi kenyamanan ekstra saat bersantai di lantai.'],
            ['name' => 'Karpet', 'file' => 'Karpet.webp', 'cat' => 'ruang-keluarga', 'price' => 400000, 'desc' => 'Karpet lantai berkualitas dengan pola menawan untuk melengkapi dekorasi ruang keluarga Anda.'],
            ['name' => 'Kasur Single', 'file' => 'Kasur Single.webp', 'cat' => 'kamar-tidur', 'price' => 1500000, 'desc' => 'Kasur busa tebal ukuran single dengan material penyokong tulang belakang untuk tidur yang sehat.'],
            ['name' => 'Kasur', 'file' => 'Kasur.webp', 'cat' => 'kamar-tidur', 'price' => 2500000, 'desc' => 'Kasur pegas (spring bed) ukuran king/queen berbahan premium untuk kualitas tidur terbaik Anda.'],
            ['name' => 'Piano', 'file' => 'Piano.jpg', 'cat' => 'alat-musik', 'price' => 15000000, 'desc' => 'Piano klasik dengan tuts presisi dan suara harmonis bernuansa grand yang memukau.'],
            ['name' => 'Product 15', 'file' => 'product_15.jpg', 'cat' => 'lain-lain', 'price' => 100000, 'desc' => 'Produk miscellaneous serbaguna yang dirancang dengan material andal.'],
            ['name' => 'Product 16', 'file' => 'product_16.jpg', 'cat' => 'lain-lain', 'price' => 100000, 'desc' => 'Produk miscellaneous serbaguna yang siap memenuhi berbagai kebutuhan rumah Anda.'],
            ['name' => 'Sofa', 'file' => 'Sofa.jpg', 'cat' => 'ruang-keluarga', 'price' => 3500000, 'desc' => 'Sofa empuk dengan desain kekinian dan kain yang nyaman, cocok untuk bersantai bersama keluarga.'],
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
                'description' => $item['desc'],
            ]);

            // Hubungkan ke kategori yang tepat
            $category = Category::where('slug', $item['cat'])->first();
            if ($category) {
                $product->categories()->attach($category->id);
            }
        }
    }
}