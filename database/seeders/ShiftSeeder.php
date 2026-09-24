<?php

namespace Database\Seeders;

use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        // Cari atau buat user sampel untuk Alan dan Deo
        $alan = User::firstOrCreate(
            ['email' => 'alan@supplier.com'],
            [
                'name'         => 'Alan',
                'password'     => bcrypt('password'),
                'role'         => 'karyawan',
                'kontrak_gaji' => 'bulanan',
            ]
        );

        $deo = User::firstOrCreate(
            ['email' => 'deo@supplier.com'],
            [
                'name'         => 'Deo',
                'password'     => bcrypt('password'),
                'role'         => 'karyawan',
                'kontrak_gaji' => 'dua_kali',
            ]
        );

        // Periode jadwal: Bulan Berjalan
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();
        $period = CarbonPeriod::create($start, $end);

        // 1. Alan: Senin, Rabu, Jumat (08:00 - 12:00)
        $hariAlan = ['Monday', 'Wednesday', 'Friday'];
        foreach ($period as $date) {
            if (in_array($date->format('l'), $hariAlan)) {
                Shift::firstOrCreate([
                    'user_id' => $alan->id,
                    'tanggal' => $date->format('Y-m-d'),
                ], [
                    'jam_mulai'   => '08:00:00',
                    'jam_selesai' => '12:00:00',
                ]);
            }
        }

        // 2. Deo: Selasa, Rabu, Kamis, Jumat (09:00 - 14:00)
        $hariDeo = ['Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach ($period as $date) {
            if (in_array($date->format('l'), $hariDeo)) {
                Shift::firstOrCreate([
                    'user_id' => $deo->id,
                    'tanggal' => $date->format('Y-m-d'),
                ], [
                    'jam_mulai'   => '09:00:00',
                    'jam_selesai' => '14:00:00',
                ]);
            }
        }
    }
}