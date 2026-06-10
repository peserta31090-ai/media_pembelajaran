<?php

namespace Database\Seeders;

use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\VideoPembelajaran;
use Illuminate\Database\Seeder;

class BackfillMapelSeeder extends Seeder
{
    public function run(): void
    {
        // Backfill materis
        $materisWithoutMapel = Materi::whereNull('mapel_id')->get();
        foreach ($materisWithoutMapel as $materi) {
            $mapel = Mapel::where('kelas_id', $materi->kelas_id)->first();
            if ($mapel) {
                $materi->update(['mapel_id' => $mapel->id]);
            }
        }

        // Backfill tugas
        $tugasWithoutMapel = Tugas::whereNull('mapel_id')->get();
        foreach ($tugasWithoutMapel as $tugas) {
            $mapel = Mapel::where('kelas_id', $tugas->kelas_id)->first();
            if ($mapel) {
                $tugas->update(['mapel_id' => $mapel->id]);
            }
        }

        // Backfill kuis
        $kuisWithoutMapel = Kuis::whereNull('mapel_id')->get();
        foreach ($kuisWithoutMapel as $kuis) {
            $mapel = Mapel::where('kelas_id', $kuis->kelas_id)->first();
            if ($mapel) {
                $kuis->update(['mapel_id' => $mapel->id]);
            }
        }

        // Backfill videoPembelajarans
        $videosWithoutMapel = VideoPembelajaran::whereNull('mapel_id')->get();
        foreach ($videosWithoutMapel as $video) {
            $mapel = Mapel::where('kelas_id', $video->kelas_id)->first();
            if ($mapel) {
                $video->update(['mapel_id' => $mapel->id]);
            }
        }
    }
}
