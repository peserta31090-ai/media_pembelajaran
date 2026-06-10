<?php

namespace App\Console\Commands;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Console\Command;

class CleanupOldKelas extends Command
{
    protected $signature = 'cleanup:old-kelas';
    protected $description = 'Remove old subject-based classes and keep only X, XI, XII';

    public function handle()
    {
        // Get the new 3 classes
        $newKelas = Kelas::whereIn('nama_kelas', ['X', 'XI', 'XII'])->get();
        
        if ($newKelas->count() < 3) {
            $this->error('Could not find all 3 main classes (X, XI, XII)');
            return 1;
        }

        $kelasX = $newKelas->firstWhere('nama_kelas', 'X');
        $kelasXI = $newKelas->firstWhere('nama_kelas', 'XI');
        $kelasXII = $newKelas->firstWhere('nama_kelas', 'XII');

        // Get old classes (those with " - " in the name)
        $oldKelas = Kelas::where('nama_kelas', 'LIKE', '% - %')->get();

        // Reassign siswa from old classes to new classes based on grade level
        foreach ($oldKelas as $oldKela) {
            $targetKelas = null;
            
            // Determine target class based on current class name
            if (str_starts_with($oldKela->nama_kelas, 'X - ')) {
                $targetKelas = $kelasX;
            } elseif (str_starts_with($oldKela->nama_kelas, 'XI - ')) {
                $targetKelas = $kelasXI;
            } elseif (str_starts_with($oldKela->nama_kelas, 'XII - ')) {
                $targetKelas = $kelasXII;
            }

            // Reassign siswa if target found
            if ($targetKelas) {
                $oldKela->siswas()->update(['kelas_id' => $targetKelas->id]);
            }
        }

        // Delete old classes (with their associated data)
        $deletedCount = 0;
        foreach ($oldKelas as $kela) {
            // Delete associated data first
            $kela->materis()->delete();
            $kela->tugas()->delete();
            $kela->kuis()->delete();
            $kela->videoPembelajarans()->delete();
            $kela->mapels()->delete();
            
            $kela->delete();
            $deletedCount++;
        }

        $this->info("✓ Deleted {$deletedCount} old classes");
        $this->info("✓ Kept 3 main classes: X, XI, XII");
        $this->info("✓ Reassigned all students to appropriate grade levels");
        return 0;
    }
