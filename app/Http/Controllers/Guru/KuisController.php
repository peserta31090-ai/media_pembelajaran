<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKuisRequest;
use App\Http\Requests\StoreSoalKuisRequest;
use App\Models\HasilKuis;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\SoalKuis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KuisController extends Controller
{
    public function index(Request $request)
    {
        $guruId = Auth::user()->guru->id;

        if ($request->ajax()) {
            $kuis = Kuis::where('guru_id', $guruId)->with('kelas', 'mapel')->select('kuis.*');

            return DataTables::of($kuis)
                ->addIndexColumn()
                ->addColumn('mapel', fn ($k) => $k->mapel?->nama_mapel ?? '-')
                ->addColumn('jumlah_soal', fn ($k) => $k->soalKuis()->count())
                ->addColumn('action', function ($k) {
                    return '
                        <a href="'.route('guru.kuis.soal', $k->id).'" class="btn btn-sm btn-primary"><i class="bi bi-question-circle"></i></a>
                        <a href="'.route('guru.kuis.hasil', $k->id).'" class="btn btn-sm btn-info"><i class="bi bi-bar-chart"></i></a>
                        <a href="'.route('guru.kuis.edit', $k->id).'" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete('.$k->id.')"><i class="bi bi-trash"></i></button>
                        <form id="delete-form-'.$k->id.'" action="'.route('guru.kuis.destroy', $k->id).'" method="POST" style="display:none;">
                            '.csrf_field().method_field('DELETE').'
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $kelas = Kelas::all();
        $mapels = Mapel::where('guru_id', Auth::user()->guru->id)->get();

        return view('guru.kuis.index', compact('kelas', 'mapels'));
    }

    public function store(StoreKuisRequest $request)
    {
        Kuis::create([
            'judul' => $request->judul,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => Auth::user()->guru->id,
        ]);

        return redirect()->route('guru.kuis.index')->with('success', 'Kuis berhasil ditambahkan.');
    }

    public function edit(Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $kelas = Kelas::all();
        $guruId = Auth::user()->guru->id;
        $mapels = Mapel::where('guru_id', $guruId)->get();

        return view('guru.kuis.edit', compact('kuis', 'kelas', 'mapels'));
    }

    public function update(StoreKuisRequest $request, Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $kuis->update($request->validated());

        return redirect()->route('guru.kuis.index')->with('success', 'Kuis berhasil diperbarui.');
    }

    public function destroy(Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $kuis->delete();

        return redirect()->route('guru.kuis.index')->with('success', 'Kuis berhasil dihapus.');
    }

    public function soal(Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $soal = SoalKuis::where('kuis_id', $kuis->id)->get();

        return view('guru.kuis.soal', compact('kuis', 'soal'));
    }

    public function storeSoal(StoreSoalKuisRequest $request, Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }

        SoalKuis::create([
            'kuis_id' => $kuis->id,
            'pertanyaan' => $request->pertanyaan,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->route('guru.kuis.soal', $kuis->id)->with('success', 'Soal berhasil ditambahkan.');
    }

    public function destroySoal(SoalKuis $soalKuis)
    {
        $kuis = $soalKuis->kuis;
        if ($kuis->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $soalKuis->delete();

        return redirect()->route('guru.kuis.soal', $kuis->id)->with('success', 'Soal berhasil dihapus.');
    }

    public function hasil(Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $hasil = HasilKuis::where('kuis_id', $kuis->id)->with('siswa.user')->get();

        return view('guru.kuis.hasil', compact('kuis', 'hasil'));
    }
}
