<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\VideoPembelajaran;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index()
    {
        $kelasId = Auth::user()->siswa->kelas_id;
        $video = VideoPembelajaran::where('kelas_id', $kelasId)->with('guru.user', 'mapel')->latest()->get();

        return view('siswa.video.index', compact('video'));
    }
}
