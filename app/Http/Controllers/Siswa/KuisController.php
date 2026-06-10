<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilKuis;
use App\Models\Kuis;
use App\Models\SoalKuis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisController extends Controller
{
    public function index()
    {
        $kelasId = Auth::user()->siswa->kelas_id;
        $kuis = Kuis::where('kelas_id', $kelasId)->with('guru.user', 'mapel')->latest()->get();

        return view('siswa.kuis.index', compact('kuis'));
    }

    public function mulai(Kuis $kuis)
    {
        $kelasId = Auth::user()->siswa->kelas_id;
        if ($kuis->kelas_id !== $kelasId) {
            abort(403);
        }

        $sudahDikerjakan = HasilKuis::where('kuis_id', $kuis->id)
            ->where('siswa_id', Auth::user()->siswa->id)
            ->exists();

        if ($sudahDikerjakan) {
            return redirect()->route('siswa.kuis.index')->with('error', 'Anda sudah mengerjakan kuis ini.');
        }

        $soal = SoalKuis::where('kuis_id', $kuis->id)->get();

        return view('siswa.kuis.kerjakan', compact('kuis', 'soal'));
    }

    public function submit(Request $request, Kuis $kuis)
    {
        $kelasId = Auth::user()->siswa->kelas_id;
        if ($kuis->kelas_id !== $kelasId) {
            abort(403);
        }

        $sudahDikerjakan = HasilKuis::where('kuis_id', $kuis->id)
            ->where('siswa_id', Auth::user()->siswa->id)
            ->exists();

        if ($sudahDikerjakan) {
            return redirect()->route('siswa.kuis.index')->with('error', 'Anda sudah mengerjakan kuis ini.');
        }

        $soal = SoalKuis::where('kuis_id', $kuis->id)->get();
        $benar = 0;

        foreach ($soal as $s) {
            $jawaban = $request->input('jawaban_'.$s->id);
            if ($jawaban === $s->jawaban_benar) {
                $benar++;
            }
        }

        $total = $soal->count();
        $nilai = $total > 0 ? round(($benar / $total) * 100) : 0;

        HasilKuis::create([
            'kuis_id' => $kuis->id,
            'siswa_id' => Auth::user()->siswa->id,
            'nilai' => $nilai,
        ]);

        return redirect()->route('siswa.kuis.hasil', $kuis->id)->with('success', "Kuis selesai! Nilai Anda: $nilai");
    }

    public function hasil(Kuis $kuis)
    {
        $kelasId = Auth::user()->siswa->kelas_id;
        if ($kuis->kelas_id !== $kelasId) {
            abort(403);
        }

        $hasil = HasilKuis::where('kuis_id', $kuis->id)
            ->where('siswa_id', Auth::user()->siswa->id)
            ->first();

        if (! $hasil) {
            return redirect()->route('siswa.kuis.index')->with('error', 'Anda belum mengerjakan kuis ini.');
        }

        return view('siswa.kuis.hasil', compact('kuis', 'hasil'));
    }
}
