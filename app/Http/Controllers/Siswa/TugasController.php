<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index()
    {
        $kelasId = Auth::user()->siswa->kelas_id;
        $tugas = Tugas::where('kelas_id', $kelasId)->with('guru.user', 'mapel')->latest()->get();

        return view('siswa.tugas.index', compact('tugas'));
    }

    public function show(Tugas $tuga)
    {
        $kelasId = Auth::user()->siswa->kelas_id;
        if ($tuga->kelas_id !== $kelasId) {
            abort(403);
        }

        $pengumpulan = PengumpulanTugas::where('tugas_id', $tuga->id)
            ->where('siswa_id', Auth::user()->siswa->id)
            ->first();

        return view('siswa.tugas.show', compact('tuga', 'pengumpulan'));
    }

    public function upload(Request $request, Tugas $tuga)
    {
        $kelasId = Auth::user()->siswa->kelas_id;
        if ($tuga->kelas_id !== $kelasId) {
            abort(403);
        }

        $request->validate([
            'file_jawaban' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $file = $request->file('file_jawaban');
        $path = $file->store('tugas', 'public');

        PengumpulanTugas::updateOrCreate(
            [
                'tugas_id' => $tuga->id,
                'siswa_id' => Auth::user()->siswa->id,
            ],
            ['file_jawaban' => $path]
        );

        return redirect()->route('siswa.tugas.show', $tuga->id)->with('success', 'Tugas berhasil dikumpulkan.');
    }
}
