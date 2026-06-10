<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index(Kelas $kela)
    {
        $mapels = $kela->mapels()->withCount('materis', 'tugas', 'kuis')->get();
        $gurus = Guru::all();

        return view('admin.mapel.index', compact('kela', 'mapels', 'gurus'));
    }

    public function store(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        $kela->mapels()->create($request->all());

        return redirect()->route('admin.mapel.index', $kela)->with('success', 'Mapel berhasil ditambahkan.');
    }

    public function update(Request $request, Kelas $kela, Mapel $mapel)
    {
        // Check if mapel belongs to kelas
        if ($mapel->kelas_id !== $kela->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        $mapel->update($request->all());

        return redirect()->route('admin.mapel.index', $kela)->with('success', 'Mapel berhasil diperbarui.');
    }

    public function destroy(Kelas $kela, Mapel $mapel)
    {
        // Check if mapel belongs to kelas
        if ($mapel->kelas_id !== $kela->id) {
            abort(403, 'Unauthorized');
        }

        $mapel->delete();

        return redirect()->route('admin.mapel.index', $kela)->with('success', 'Mapel berhasil dihapus.');
    }
}
