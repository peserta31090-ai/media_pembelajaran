<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gurus = Guru::with('user')->select('gurus.*');

            return DataTables::of($gurus)
                ->addIndexColumn()
                ->addColumn('name', fn ($guru) => $guru->user->name)
                ->addColumn('email', fn ($guru) => $guru->user->email)
                ->addColumn('action', function ($guru) {
                    return '
                        <a href="'.route('admin.guru.show', $guru->id).'" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        <a href="'.route('admin.guru.edit', $guru->id).'" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete('.$guru->id.')"><i class="bi bi-trash"></i></button>
                        <form id="delete-form-'.$guru->id.'" action="'.route('admin.guru.destroy', $guru->id).'" method="POST" style="display:none;">
                            '.csrf_field().method_field('DELETE').'
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.guru.index');
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(StoreGuruRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru)
    {
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $guru->user->update($userData);

        $guru->update([
            'nip' => $request->nip,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->user->delete();
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
