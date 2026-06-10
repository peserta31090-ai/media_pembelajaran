@extends('layouts.siswa')
@section('title', $materi->judul)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">{{ $materi->judul }}</h4>
    <a href="{{ route('siswa.materi.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        @if($materi->mapel)
            <div class="mb-3">
                <strong>Mata Pelajaran:</strong>
                <p>{{ $materi->mapel->nama_mapel }}</p>
            </div>
        @endif
        <div class="mb-3">
            <strong>Deskripsi:</strong>
            <p>{{ $materi->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
        </div>
        <div class="mb-3">
            <strong>Guru Pengajar:</strong>
            <p>{{ $materi->guru->user->name }}</p>
        </div>
        <div class="mb-3">
            <strong>File:</strong><br>
            <a href="{{ asset('storage/'.$materi->file) }}" target="_blank" class="btn btn-primary mt-1"><i class="bi bi-download"></i> Download File</a>
        </div>
    </div>
</div>
@endsection
