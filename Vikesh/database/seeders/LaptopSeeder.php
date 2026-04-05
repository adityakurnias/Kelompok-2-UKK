<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laptop; 

class LaptopSeeder extends Seeder
{
    public function run(): void
    {
        // Kalimat garansi di depan dengan Page Break (---)
        $header = "Garansi device 1 tahun sejak tanggal pembelian. \n\n --- \n\n";

        Laptop::create([
            'model' => 'Lenovo ThinkPad T440p',
            'processor' => 'Intel Core i5-4300M',
            'ram' => '16GB',
            'storage' => '256GB SSD',
            'price' => 1200000,
            'description' => $header . "Specs: Intel Core i5-4300M, RAM 16GB, SSD 256GB. Laptop bisnis tangguh dengan bodi kokoh khas ThinkPad.",
            'image' => 'images/t440p.jpg'
        ]);

        Laptop::create([
            'model' => 'Lenovo ThinkPad X1 Carbon Gen 6',
            'processor' => 'Intel Core i7-8550U',
            'ram' => '16GB',
            'storage' => '512GB NVMe',
            'price' => 5500000,
            'description' => $header . "Specs: Intel Core i7-8550U, RAM 16GB, NVMe 512GB. Seri Ultrabook premium yang sangat tipis dan ringan.",
            'image' => 'images/x1c6.jpg'
        ]);

        Laptop::create([
            'model' => 'Lenovo ThinkPad T480',
            'processor' => 'Intel Core i5-8350U',
            'ram' => '16GB',
            'storage' => '256GB SSD',
            'price' => 3500000,
            'description' => $header . "Specs: Intel Core i5-8350U, RAM 16GB, SSD 256GB. Dual battery system dan keyboard legendaris.",
            'image' => 'images/t480.jpg'
        ]);

        // SUDAH DIPERBAIKI: Dari 'bit' menjadi 'model'
        Laptop::create([
            'model' => 'Dell Latitude 7480', 
            'processor' => 'Intel Core i7-7600U',
            'ram' => '8GB',
            'storage' => '256GB SSD',
            'price' => 3200000,
            'description' => $header . "Specs: Intel Core i7-7600U, RAM 8GB, SSD 256GB. Desain elegan dengan layar Full HD IPS jernih.",
            'image' => 'images/dell7480.jpg'
        ]);

        Laptop::create([
            'model' => 'ThinkPad E580',
            'processor' => 'Intel Core i5-8250U',
            'ram' => '8GB',
            'storage' => '1TB HDD + 128GB SSD',
            'price' => 3800000,
            'description' => $header . "Specs: Intel Core i5-8250U, RAM 8GB, SSD+HDD. Layar 15.6 inch dengan numeric keypad.",
            'image' => 'images/e580.jpg'
        ]);

        Laptop::create([
            'model' => 'IBM ThinkPad 701C',
            'processor' => 'Intel 486DX4 75MHz',
            'ram' => '16MB',
            'storage' => '540GB HDD',
            'price' => 15000000,
            'description' => $header . "Specs: Intel 486DX4, RAM 16MB. Item kolektor langka dengan Butterfly Keyboard.",
            'image' => 'images/ibm701.jpg'
        ]);

        Laptop::create([
            'model' => 'Dell OptiPlex 9020 USFF',
            'processor' => 'Intel Core i7-4770S',
            'ram' => '8GB',
            'storage' => '256GB SSD',
            'price' => 2100000,
            'description' => $header . "Specs: Intel Core i7-4770S, RAM 8GB, SSD 256GB. PC Desktop Mini hemat ruang performa tinggi.",
            'image' => 'images/optiplex.jpg'
        ]);
    }
}