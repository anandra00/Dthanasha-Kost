<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Owner (Punya Email)
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@dthanasha.com',
                'password' => Hash::make('owner123'), // Hash::make() ini wajib biar password lu jadi teks acak di database
                'role' => 'owner',
            ]
        );

        // 2. Akun Penghuni (Email Null)
        User::updateOrCreate(
            ['username' => 'penghuni1'],
            [
                'email' => null, // Sesuai skenario kita, dikosongin dulu
                'password' => Hash::make('12345678'),
                'role' => 'penghuni',
            ]
        );
    }
}