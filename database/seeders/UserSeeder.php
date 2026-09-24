<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pemilik / Owner
        User::create([
            'name'         => 'Owner Material',
            'email'        => 'owner@supplier.com',
            'password'     => Hash::make('password'),
            'role'         => 'admin',
            'kontrak_gaji' => 'bulanan',
        ]);

        // 2. Karyawan 1 (Kontrak Bulanan)
        User::create([
            'name'         => 'Budi Santoso',
            'email'        => 'budi@supplier.com',
            'password'     => Hash::make('password'),
            'role'         => 'karyawan',
            'kontrak_gaji' => 'bulanan',
        ]);

        // 3. Karyawan 2 (Kontrak Dua Kali Sebulan)
        User::create([
            'name'         => 'Joko Susilo',
            'email'        => 'joko@supplier.com',
            'password'     => Hash::make('password'),
            'role'         => 'karyawan',
            'kontrak_gaji' => 'dua_kali',
        ]);

        // 4. Karyawan 3 (Kontrak Bulanan)
        User::create([
            'name'         => 'Siti Rahma',
            'email'        => 'siti@supplier.com',
            'password'     => Hash::make('password'),
            'role'         => 'karyawan',
            'kontrak_gaji' => 'bulanan',
        ]);
    }
}