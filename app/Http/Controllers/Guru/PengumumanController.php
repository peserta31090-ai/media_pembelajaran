<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengumumanRequest;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->get();

        return view('guru.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('guru.pengumuman.create');
    }

    public function store(StorePengumumanRequest $request)
    {
        Pengumuman::create($request->validated());

        return redirect()->route('guru.pengumuman.index')->with('success', 'Pengumuman berhasil dibuat.');
    }
}
