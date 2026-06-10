<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelasData = [
            'X',
            'XI',
            'XII',
        ];

        foreach ($kelasData as $nama) {
            Kelas::firstOrCreate(
                ['nama_kelas' => $nama],
                ['nama_kelas' => $nama]
            );
        }
    }
}
