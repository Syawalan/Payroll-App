<?php

namespace Database\Seeders;

use App\Models\Laporan;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        Laporan::create([
            'periode'     => 'Agustus 2026',
            'file_export' => 'exports/laporan_penggajian_agustus_2026.csv',
        ]);

        Laporan::create([
            'periode'     => 'Juli 2026',
            'file_export' => 'exports/laporan_penggajian_juli_2026.csv',
        ]);
    }
}