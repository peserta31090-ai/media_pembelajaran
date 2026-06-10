@extends('layouts.admin')
@section('title', 'Detail Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Detail Siswa</h4>
    <div>
        <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><td class="fw-bold" style="width: 150px;">Nama</td><td>{{ $siswa->user->name }}</td></tr>
                    <tr><td class="fw-bold">Email</td><td>{{ $siswa->user->email }}</td></tr>
                    <tr><td class="fw-bold">NIS</td><td>{{ $siswa->nis }}</td></tr>
                    <tr><td class="fw-bold">Kelas</td><td>{{ $siswa->kelas->nama_kelas }}</td></tr>
                    <tr><td class="fw-bold">No. HP</td><td>{{ $siswa->no_hp ?? '-' }}</td></tr>
                    <tr><td class="fw-bold">Alamat</td><td>{{ $siswa->alamat ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
