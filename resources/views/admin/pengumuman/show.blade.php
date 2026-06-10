@extends('layouts.admin')
@section('title', $pengumuman->judul)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">{{ $pengumuman->judul }}</h4>
    <div>
        <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <small class="text-muted">{{ $pengumuman->created_at->format('d/m/Y H:i') }}</small>
        <hr>
        <p>{{ $pengumuman->isi }}</p>
    </div>
</div>
@endsection
