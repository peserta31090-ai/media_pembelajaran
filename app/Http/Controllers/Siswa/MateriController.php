<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index()
    {
        $kelasId = Auth::user()->siswa->kelas_id;
        $materi = Materi::where('kelas_id', $kelasId)->with('guru.user', 'mapel')->latest()->get();

        return view('siswa.materi.index', compact('materi'));
    }

    public function show(Materi $materi)
    {
        $materi->load('guru.user', 'mapel');
        $kelasId = Auth::user()->siswa->kelas_id;
        if ($materi->kelas_id !== $kelasId) {
            abort(403);
        }

        return view('siswa.materi.show', compact('materi'));
    }
}
