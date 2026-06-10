<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengumumanRequest;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pengumuman = Pengumuman::latest()->get();

            return DataTables::of($pengumuman)
                ->addIndexColumn()
                ->addColumn('isi', fn ($p) => Str::limit($p->isi, 50))
                ->addColumn('tanggal', fn ($p) => $p->created_at->format('d/m/Y H:i'))
                ->addColumn('action', function ($p) {
                    return '
                        <a href="'.route('admin.pengumuman.show', $p->id).'" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        <a href="'.route('admin.pengumuman.edit', $p->id).'" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete('.$p->id.')"><i class="bi bi-trash"></i></button>
                        <form id="delete-form-'.$p->id.'" action="'.route('admin.pengumuman.destroy', $p->id).'" method="POST" style="display:none;">
                            '.csrf_field().method_field('DELETE').'
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pengumuman.index');
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(StorePengumumanRequest $request)
    {
        Pengumuman::create($request->validated());

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function show(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(StorePengumumanRequest $request, Pengumuman $pengumuman)
    {
        $pengumuman->update($request->validated());

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
