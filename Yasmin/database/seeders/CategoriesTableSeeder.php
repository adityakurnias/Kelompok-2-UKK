<?php
// database/seeders/CategoriesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Pakaian',
            'Elektronik',
            'Buku',
            'Perabotan Rumah',
            'Aksesoris',
            'Olahraga',
            'Mainan',
            'Kecantikan'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category],
                ['slug' => \Str::slug($category)]
            );
        }
    }
}