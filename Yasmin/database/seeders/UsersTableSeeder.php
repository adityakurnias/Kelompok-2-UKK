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
        User::updateOrCreate(
            ['email' => 'admin@preloved.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'phone' => '08123456789',
                'address' => 'Jl. Admin No. 1',
                'role' => 'admin'
            ]
        );

        // Buyer
        User::updateOrCreate(
            ['email' => 'budi@email.com'],
            [
                'name' => 'Budi Pembeli',
                'password' => Hash::make('password'),
                'phone' => '08123456780',
                'address' => 'Jl. Pembeli No. 1',
                'role' => 'buyer'
            ]
        );

        // Seller
        User::updateOrCreate(
            ['email' => 'ani@email.com'],
            [
                'name' => 'Ani Penjual',
                'password' => Hash::make('password'),
                'phone' => '08123456781',
                'address' => 'Jl. Penjual No. 1',
                'role' => 'seller'
            ]
        );
    }
}