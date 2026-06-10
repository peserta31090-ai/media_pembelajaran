<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilKuis;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $siswaId = Auth::user()->siswa->id;
        $kelasId = Auth::user()->siswa->kelas_id;

        $nilaiTugas = PengumpulanTugas::where('siswa_id', $siswaId)
            ->whereNotNull('nilai')
            ->with('tugas.mapel')
            ->get();

        $nilaiKuis = HasilKuis::where('siswa_id', $siswaId)
            ->with('kuis')
            ->get();

        $tugasCount = Tugas::where('kelas_id', $kelasId)->count();
        $dikerjakanCount = $nilaiTugas->count();
        $rataTugas = $nilaiTugas->avg('nilai');
        $rataKuis = $nilaiKuis->avg('nilai');

        return view('siswa.nilai.index', compact(
            'nilaiTugas', 'nilaiKuis', 'rataTugas', 'rataKuis',
            'tugasCount', 'dikerjakanCount'
        ));
    }

    public function cetakPdf()
    {
        $siswa = Auth::user()->siswa->load('user', 'kelas');

        $nilaiTugas = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->whereNotNull('nilai')
            ->with('tugas.mapel')
            ->get();

        $nilaiKuis = HasilKuis::where('siswa_id', $siswa->id)
            ->with('kuis')
            ->get();

        $rataTugas = $nilaiTugas->avg('nilai');
        $rataKuis = $nilaiKuis->avg('nilai');

        $pdf = Pdf::loadView('siswa.nilai.pdf', compact(
            'siswa', 'nilaiTugas', 'nilaiKuis', 'rataTugas', 'rataKuis'
        ));

        return $pdf->download('nilai-'.$siswa->user->name.'.pdf');
    }
}
