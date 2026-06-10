<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $siswas = Siswa::with('user', 'kelas')->select('siswas.*');

            return DataTables::of($siswas)
                ->addIndexColumn()
                ->addColumn('name', fn ($s) => $s->user->name)
                ->addColumn('email', fn ($s) => $s->user->email)
                ->addColumn('kelas', fn ($s) => $s->kelas->nama_kelas)
                ->addColumn('action', function ($s) {
                    return '
                        <a href="'.route('admin.siswa.show', $s->id).'" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        <a href="'.route('admin.siswa.edit', $s->id).'" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete('.$s->id.')"><i class="bi bi-trash"></i></button>
                        <form id="delete-form-'.$s->id.'" action="'.route('admin.siswa.destroy', $s->id).'" method="POST" style="display:none;">
                            '.csrf_field().method_field('DELETE').'
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $kelas = Kelas::all();

        return view('admin.siswa.index', compact('kelas'));
    }

    public function create()
    {
        $kelas = Kelas::all();

        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(StoreSiswaRequest $request)
    {
        $email = $request->email ?? strtolower(str_replace(' ', '', $request->name)).'.'.$request->nis.'@siswa.sch.id';
        $password = $request->password ?? $request->nis;

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'kelas_id' => $request->kelas_id,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan. Email: '.$email.', Password: '.$password);
    }

    public function show(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();

        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $siswa->user->update($userData);

        $siswa->update([
            'nis' => $request->nis,
            'kelas_id' => $request->kelas_id,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->user->delete();
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function importForm()
    {
        $kelas = Kelas::all();

        return view('admin.siswa.import', compact('kelas'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $file = $request->file('file');
        $kelasId = $request->kelas_id;
        $defaultPassword = $request->default_password;

        $data = [];
        $extension = $file->getClientOriginalExtension();

        if (in_array($extension, ['xlsx', 'xls'])) {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            $header = array_shift($rows);
            $data = $rows;
        } else {
            $handle = fopen($file->getPathname(), 'r');
            $header = fgetcsv($handle);
            $data = [];
            while (($row = fgetcsv($handle)) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }

        $header = array_map('trim', array_map('strtolower', $header ?? []));
        $nameIdx = array_search('nama', $header);
        $nisIdx = array_search('nis', $header);

        if ($nameIdx === false || $nisIdx === false) {
            return redirect()->back()->with('error', 'Format file tidak valid. Kolom "nama" dan "nis" wajib ada.');
        }

        $imported = 0;
        $errors = [];

        foreach ($data as $index => $row) {
            $row = array_map('trim', $row);
            $name = $row[$nameIdx] ?? '';
            $nis = $row[$nisIdx] ?? '';

            if (empty($name) || empty($nis)) {
                continue;
            }

            if (Siswa::where('nis', $nis)->exists()) {
                $errors[] = 'Baris '.($index + 2).": NIS $nis sudah terdaftar.";

                continue;
            }

            try {
                $email = strtolower(str_replace(' ', '', $name)).'.'.$nis.'@siswa.sch.id';
                $password = $defaultPassword ?? $nis;

                $email = $this->makeUniqueEmail($email);

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make((string) $password),
                    'role' => 'siswa',
                ]);

                Siswa::create([
                    'user_id' => $user->id,
                    'nis' => $nis,
                    'kelas_id' => $kelasId,
                ]);

                $imported++;
            } catch (\Exception $e) {
                $errors[] = 'Baris '.($index + 2)." ($name): ".$e->getMessage();
            }
        }

        $message = "Berhasil mengimpor $imported siswa.";
        if (! empty($errors)) {
            $message .= ' Gagal: '.implode(', ', array_slice($errors, 0, 5));
            if (count($errors) > 5) {
                $message .= ' dan '.(count($errors) - 5).' lainnya.';
            }
        }

        return redirect()->route('admin.siswa.index')->with('success', $message);
    }

    private function makeUniqueEmail($email)
    {
        $original = $email;
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = str_replace('@', $counter.'@', $original);
            $counter++;
        }

        return $email;
    }
}
