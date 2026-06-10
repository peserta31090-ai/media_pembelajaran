<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kuis;
use App\Models\Materi;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use App\Models\VideoPembelajaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guruId = Auth::user()->guru->id;

        $data = [
            'totalMateri' => Materi::where('guru_id', $guruId)->count(),
            'totalVideo' => VideoPembelajaran::where('guru_id', $guruId)->count(),
            'totalTugas' => Tugas::where('guru_id', $guruId)->count(),
            'totalKuis' => Kuis::where('guru_id', $guruId)->count(),
            'totalPengumpulan' => PengumpulanTugas::whereHas('tugas', fn ($q) => $q->where('guru_id', $guruId))->count(),
            'materiTerbaru' => Materi::where('guru_id', $guruId)->with('kelas')->latest()->take(5)->get(),
            'tugasTerbaru' => Tugas::where('guru_id', $guruId)->with('kelas')->latest()->take(5)->get(),
        ];

        return view('guru.dashboard', $data);
    }
}
