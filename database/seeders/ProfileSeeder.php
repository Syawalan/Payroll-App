<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $dataProfiles = [
            'owner@supplier.com' => [
                'alamat' => 'Jl. Jendral Sudirman No. 100, Pekanbaru',
                'no_hp'  => '081234567890',
            ],
            'budi@supplier.com' => [
                'alamat' => 'Jl. Nangka Gang Melati No. 12, Pekanbaru',
                'no_hp'  => '081398765432',
            ],
            'joko@supplier.com' => [
                'alamat' => 'Jl. H.R. Soebrantas Km 10, Tampan',
                'no_hp'  => '082155443322',
            ],
            'siti@supplier.com' => [
                'alamat' => 'Jl. Riau Gang Harapan No. 4, Pekanbaru',
                'no_hp'  => '085211223344',
            ],
        ];

        foreach ($users as $user) {
            $info = $dataProfiles[$user->email] ?? [
                'alamat' => 'Jl. Merdeka No. ' . rand(1, 50),
                'no_hp'  => '0812' . rand(10000000, 99999999),
            ];

            Profile::create([
                'user_id' => $user->id,
                'alamat'  => $info['alamat'],
                'no_hp'   => $info['no_hp'],
            ]);
        }
    }
}