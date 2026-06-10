<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMateriRequest;
use App\Http\Requests\UpdateMateriRequest;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $guruId = Auth::user()->guru->id;

        if ($request->ajax()) {
            $materi = Materi::where('guru_id', $guruId)->with('kelas', 'mapel')->select('materis.*');

            return DataTables::of($materi)
                ->addIndexColumn()
                ->addColumn('mapel', fn ($m) => $m->mapel?->nama_mapel ?? '-')
                ->addColumn('file_link', fn ($m) => '<a href="'.asset('storage/'.$m->file).'" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-download"></i> Download</a>')
                ->addColumn('action', function ($m) {
                    return '
                        <a href="'.route('guru.materi.edit', $m->id).'" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete('.$m->id.')"><i class="bi bi-trash"></i></button>
                        <form id="delete-form-'.$m->id.'" action="'.route('guru.materi.destroy', $m->id).'" method="POST" style="display:none;">
                            '.csrf_field().method_field('DELETE').'
                        </form>
                    ';
                })
                ->rawColumns(['file_link', 'action'])
                ->make(true);
        }

        $kelas = Kelas::all();
        $mapels = Mapel::where('guru_id', $guruId)->get();

        return view('guru.materi.index', compact('kelas', 'mapels'));
    }

    public function store(StoreMateriRequest $request)
    {
        $file = $request->file('file');
        $path = $file->store('materi', 'public');

        Materi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $path,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => Auth::user()->guru->id,
        ]);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Materi $materi)
    {
        if ($materi->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        $kelas = Kelas::all();
        $guruId = Auth::user()->guru->id;
        $mapels = Mapel::where('guru_id', $guruId)->get();

        return view('guru.materi.edit', compact('materi', 'kelas', 'mapels'));
    }

    public function update(UpdateMateriRequest $request, Materi $materi)
    {
        if ($materi->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($materi->file && Storage::disk('public')->exists($materi->file)) {
                Storage::disk('public')->delete($materi->file);
            }
            $data['file'] = $request->file('file')->store('materi', 'public');
        }

        $materi->update($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        if ($materi->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }
        if ($materi->file && Storage::disk('public')->exists($materi->file)) {
            Storage::disk('public')->delete($materi->file);
        }
        $materi->delete();

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
