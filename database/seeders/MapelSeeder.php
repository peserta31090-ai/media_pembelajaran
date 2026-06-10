<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create a default guru for subjects
        $defaultGuru = Guru::first();
        if (! $defaultGuru) {
            // Create a dummy guru if none exists (should not happen in normal flow)
            $defaultGuru = Guru::create([
                'user_id' => 1,
                'nip' => '000000',
                'alamat' => 'Default',
                'no_hp' => '000000',
            ]);
        }

        $mapelData = [
            'X' => [
                'Berpikir Komputasional',
                'Sistem Komputer',
                'Jaringan Komputer Dasar',
                'Algoritma dan Pemrograman Dasar',
                'Keamanan Digital',
            ],
            'XI' => [
                'Pemrograman Web',
                'Basis Data',
                'Jaringan Komputer Lanjutan',
                'Analisis Data',
                'UI/UX Dasar',
            ],
            'XII' => [
                'Pemrograman Berorientasi Objek',
                'Pengembangan Aplikasi',
                'Internet of Things (IoT)',
                'Kecerdasan Buatan Dasar',
                'Proyek Informatika',
            ],
        ];

        foreach ($mapelData as $kelasNama => $mapels) {
            $kelas = Kelas::where('nama_kelas', $kelasNama)->first();

            if ($kelas) {
                foreach ($mapels as $mapelNama) {
                    Mapel::firstOrCreate(
                        [
                            'nama_mapel' => $mapelNama,
                            'kelas_id' => $kelas->id,
                        ],
                        [
                            'nama_mapel' => $mapelNama,
                            'kelas_id' => $kelas->id,
                            'guru_id' => $defaultGuru->id,
                        ]
                    );
                }
            }
        }
    }
}
