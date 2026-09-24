<?php

namespace Database\Seeders;

use App\Models\Penggajian;
use App\Models\User;
use Illuminate\Database\Seeder;

class PenggajianSeeder extends Seeder
{
    public function run(): void
    {
        $karyawans = User::where('role', 'karyawan')->get();

        foreach ($karyawans as $karyawan) {
            // 1. Slip Gaji Lunas (Bulan Lalu)
            Penggajian::create([
                'user_id'      => $karyawan->id,
                'periode'      => 'Agustus 2026',
                'total_volume' => 1000,
                'tarif'        => 3000.00,
                'total_gaji'   => 1000 * 3000.00, // 3.000.000
                'status'       => 'dibayar',
                'bukti'        => null,
            ]);

            // 2. Slip Gaji Pending (Bulan Ini)
            Penggajian::create([
                'user_id'      => $karyawan->id,
                'periode'      => 'September 2026',
                'total_volume' => 750,
                'tarif'        => 3000.00,
                'total_gaji'   => 750 * 3000.00, // 2.250.000
                'status'       => 'belum',
                'bukti'        => null,
            ]);
        }
    }
}