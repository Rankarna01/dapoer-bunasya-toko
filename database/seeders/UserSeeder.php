<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun ADMIN
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@bakery.com',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Kantor Pusat BakeryLuxe'
        ]);

        // 2. Akun KASIR
        User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@bakery.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'phone' => '089876543210',
            'address' => 'Cabang Utama'
        ]);

        // 3. Akun PELANGGAN (Contoh)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'phone' => '081122334455',
            'address' => 'Jl. Mawar No. 10, Jakarta Selatan'
        ]);
    }
}