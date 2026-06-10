@extends('layouts.siswa')
@section('title', 'Hasil Kuis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Hasil Kuis: {{ $kuis->judul }}</h4>
    <a href="{{ route('siswa.kuis.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body text-center py-5">
        <div class="display-1 fw-bold text-{{ $hasil->nilai >= 70 ? 'success' : 'danger' }}">{{ $hasil->nilai }}</div>
        <p class="fs-5">Nilai Anda</p>
        @if($hasil->nilai >= 70)
            <p class="text-success">Selamat! Anda lulus.</p>
        @else
            <p class="text-danger">Tetap semangat dan coba lagi.</p>
        @endif
    </div>
</div>
@endsection
