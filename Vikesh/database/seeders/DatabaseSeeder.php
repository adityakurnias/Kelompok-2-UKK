<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil LaptopSeeder agar data laptop masuk
        $this->call([
            LaptopSeeder::class,
        ]);

        // Akun Admin: Lindell
        User::create([
            'name' => 'Lindell',
            'email' => 'adminxperts@gmail.com',
            'password' => bcrypt('123456'),
            'is_admin' => 1,
        ]);

        // Akun User Biasa: thekumootil
        User::create([
            'name' => 'thekumootil',
            'email' => 'thekumootil@gmail.com',
            'password' => bcrypt('123456'),
            'is_admin' => 0,
        ]);
    }
}
