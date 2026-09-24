<?php

namespace Database\Seeders;

use App\Models\Borongan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BoronganSeeder extends Seeder
{
    public function run(): void
    {
        $karyawans = User::where('role', 'karyawan')->get();

        if ($karyawans->isEmpty()) {
            return;
        }

        $items = [
            [
                'nama_barang'   => 'Semen Padang 50kg',
                'satuan'        => 'Sak',
                'volume'        => 80,
                'alamat_tujuan' => 'Proyek Perumahan Griya Asri Blok B No. 5',
            ],
            [
                'nama_barang'   => 'Pasir Pasang Super',
                'satuan'        => 'Rit',
                'volume'        => 4,
                'alamat_tujuan' => 'Pembangunan Ruko Panam, Jl. HR Soebrantas',
            ],
            [
                'nama_barang'   => 'Batu Split 2/3',
                'satuan'        => 'm³',
                'volume'        => 15,
                'alamat_tujuan' => 'Renovasi Jalan Proyek Mandiri, Marpoyan',
            ],
            [
                'nama_barang'   => 'Besi Beton 12mm',
                'satuan'        => 'Batang',
                'volume'        => 120,
                'alamat_tujuan' => 'Pembangunan Gudang Logistik B2',
            ],
        ];

        foreach ($karyawans as $karyawan) {
            foreach ($items as $item) {
                Borongan::create([
                    'nama_barang'        => $item['nama_barang'],
                    'satuan'             => $item['satuan'],
                    'volume'             => $item['volume'],
                    'alamat_tujuan'      => $item['alamat_tujuan'],
                    'user_id'            => $karyawan->id,
                    'tanggal_pengiriman' => Carbon::now()->subDays(rand(1, 20))->format('Y-m-d'),
                ]);
            }
        }
    }
}