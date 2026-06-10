<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoRequest;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\VideoPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $guruId = Auth::user()->guru->id;

        if ($request->ajax()) {
            $video = VideoPembelajaran::where('guru_id', $guruId)->with('kelas', 'mapel')->select('video_pembelajarans.*');

            return DataTables::of($video)
                ->addIndexColumn()
                ->addColumn('mapel', fn ($v) => $v->mapel?->nama_mapel ?? '-')
                ->addColumn('link', fn ($v) => '<a href="'.$v->link_video.'" target="_blank" class="btn btn-sm btn-danger"><i class="bi bi-play-circle"></i> Tonton</a>')
                ->addColumn('action', function ($v) {
                    return '
                        <a href="'.route('guru.video.edit', $v->id).'" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete('.$v->id.')"><i class="bi bi-trash"></i></button>
                        <form id="delete-form-'.$v->id.'" action="'.route('guru.video.destroy', $v->id).'" method="POST" style="display:none;">
                            '.csrf_field().method_field('DELETE').'
                        </form>
                    ';
                })
                ->rawColumns(['link', 'action'])
                ->make(true);
        }

        $kelas = Kelas::all();
        $mapels = Mapel::where('guru_id', $guruId)->get();

        return view('guru.video.index', compact('kelas', 'mapels'));
    }

    public function store(StoreVideoRequest $request)
    {
        VideoPembelajaran::create([
            'judul' => $request->judul,
            'link_video' => $request->link_video,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => Auth::user()->guru->id,
        ]);

        return redirect()->route('guru.video.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(VideoPembelajaran $video)
    {
        if ($video->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $kelas = Kelas::all();
        $guruId = Auth::user()->guru->id;
        $mapels = Mapel::where('guru_id', $guruId)->get();

        return view('guru.video.edit', compact('video', 'kelas', 'mapels'));
    }

    public function update(StoreVideoRequest $request, VideoPembelajaran $video)
    {
        if ($video->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $video->update($request->validated());

        return redirect()->route('guru.video.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(VideoPembelajaran $video)
    {
        if ($video->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $video->delete();

        return redirect()->route('guru.video.index')->with('success', 'Video berhasil dihapus.');
    }
}
