<?php
// database/seeders/UsersTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@preloved.com',
            'password' => Hash::make('password'),
            'phone' => '08123456789',
            'address' => 'Jl. Admin No. 1',
            'role' => 'admin'
        ]);

        // Buyer
        User::create([
            'name' => 'Budi Pembeli',
            'email' => 'budi@email.com',
            'password' => Hash::make('password'),
            'phone' => '08123456780',
            'address' => 'Jl. Pembeli No. 1',
            'role' => 'buyer'
        ]);

        // Seller
        User::create([
            'name' => 'Ani Penjual',
            'email' => 'ani@email.com',
            'password' => Hash::make('password'),
            'phone' => '08123456781',
            'address' => 'Jl. Penjual No. 1',
            'role' => 'seller'
        ]);
    }
}