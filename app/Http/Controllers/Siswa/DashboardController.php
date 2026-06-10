<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilKuis;
use App\Models\Kuis;
use App\Models\Materi;
use App\Models\PengumpulanTugas;
use App\Models\Pengumuman;
use App\Models\Tugas;
use App\Models\VideoPembelajaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $kelasId = $siswa->kelas_id;

        $data = [
            'totalMateri' => Materi::where('kelas_id', $kelasId)->count(),
            'totalVideo' => VideoPembelajaran::where('kelas_id', $kelasId)->count(),
            'totalTugas' => Tugas::where('kelas_id', $kelasId)->count(),
            'totalKuis' => Kuis::where('kelas_id', $kelasId)->count(),
            'materi' => Materi::where('kelas_id', $kelasId)->with('guru.user')->latest()->get(),
            'video' => VideoPembelajaran::where('kelas_id', $kelasId)->with('guru.user')->latest()->get(),
            'tugas' => Tugas::where('kelas_id', $kelasId)->with('guru.user')->latest()->get(),
            'pengumuman' => Pengumuman::latest()->get(),
            'tugasSelesai' => PengumpulanTugas::where('siswa_id', $siswa->id)->count(),
            'nilaiRata' => HasilKuis::where('siswa_id', $siswa->id)->avg('nilai'),
        ];

        return view('siswa.dashboard', $data);
    }
}
