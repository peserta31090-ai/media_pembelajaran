@extends('layouts.admin')
@section('title', 'Detail Guru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Detail Guru</h4>
    <div>
        <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><td class="fw-bold" style="width: 150px;">Nama</td><td>{{ $guru->user->name }}</td></tr>
                    <tr><td class="fw-bold">Email</td><td>{{ $guru->user->email }}</td></tr>
                    <tr><td class="fw-bold">NIP</td><td>{{ $guru->nip }}</td></tr>
                    <tr><td class="fw-bold">No. HP</td><td>{{ $guru->no_hp ?? '-' }}</td></tr>
                    <tr><td class="fw-bold">Alamat</td><td>{{ $guru->alamat ?? '-' }}</td></tr>
                    <tr><td class="fw-bold">Bergabung</td><td>{{ $guru->created_at->format('d/m/Y H:i') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
