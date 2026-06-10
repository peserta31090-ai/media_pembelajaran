<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\Materi;
use App\Models\Pengumuman;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\VideoPembelajaran;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalGuru' => Guru::count(),
            'totalSiswa' => Siswa::count(),
            'totalMateri' => Materi::count(),
            'totalVideo' => VideoPembelajaran::count(),
            'totalTugas' => Tugas::count(),
            'totalKuis' => Kuis::count(),
            'kelasList' => Kelas::withCount('siswas')->get(),
            'pengumuman' => Pengumuman::latest()->take(5)->get(),
            'guruTerbaru' => Guru::with('user')->latest()->take(5)->get(),
            'siswaTerbaru' => Siswa::with('user', 'kelas')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
