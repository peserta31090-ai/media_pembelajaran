<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTugasRequest;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $guruId = Auth::user()->guru->id;

        if ($request->ajax()) {
            $tugas = Tugas::where('guru_id', $guruId)->with('kelas', 'mapel')->select('tugas.*');

            return DataTables::of($tugas)
                ->addIndexColumn()
                ->addColumn('mapel', fn ($t) => $t->mapel?->nama_mapel ?? '-')
                ->addColumn('deadline', fn ($t) => $t->deadline->format('d/m/Y H:i'))
                ->addColumn('jumlah_pengumpulan', fn ($t) => $t->pengumpulanTugas()->count())
                ->addColumn('action', function ($t) {
                    return '
                        <a href="'.route('guru.tugas.pengumpulan', $t->id).'" class="btn btn-sm btn-info"><i class="bi bi-folder"></i></a>
                        <a href="'.route('guru.tugas.edit', $t->id).'" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete('.$t->id.')"><i class="bi bi-trash"></i></button>
                        <form id="delete-form-'.$t->id.'" action="'.route('guru.tugas.destroy', $t->id).'" method="POST" style="display:none;">
                            '.csrf_field().method_field('DELETE').'
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $kelas = Kelas::all();
        $mapels = Mapel::where('guru_id', $guruId)->get();

        return view('guru.tugas.index', compact('kelas', 'mapels'));
    }

    public function store(StoreTugasRequest $request)
    {
        Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => Auth::user()->guru->id,
        ]);

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit(Tugas $tuga)
    {
        if ($tuga->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $kelas = Kelas::all();
        $guruId = Auth::user()->guru->id;
        $mapels = Mapel::where('guru_id', $guruId)->get();

        return view('guru.tugas.edit', compact('tuga', 'kelas', 'mapels'));
    }

    public function update(StoreTugasRequest $request, Tugas $tuga)
    {
        if ($tuga->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $tuga->update($request->validated());

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tuga)
    {
        if ($tuga->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $tuga->delete();

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }

    public function pengumpulan(Tugas $tuga)
    {
        if ($tuga->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $pengumpulan = PengumpulanTugas::where('tugas_id', $tuga->id)->with('siswa.user')->get();

        return view('guru.tugas.pengumpulan', compact('tuga', 'pengumpulan'));
    }

    public function nilai(Request $request, PengumpulanTugas $pengumpulanTuga)
    {
        $request->validate(['nilai' => 'required|integer|min:0|max:100']);
        $pengumpulanTuga->update(['nilai' => $request->nilai]);

        return redirect()->back()->with('success', 'Nilai berhasil diberikan.');
    }
}
