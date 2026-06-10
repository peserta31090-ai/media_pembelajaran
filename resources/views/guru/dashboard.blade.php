@extends('layouts.guru')
@section('title', 'Dashboard Guru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Dashboard Guru</h4>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card bg-primary text-white">
            <i class="bi bi-file-earmark-text stat-icon"></i>
            <div class="stat-value">{{ $totalMateri }}</div>
            <div class="stat-label">Total Materi</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-danger text-white">
            <i class="bi bi-play-circle stat-icon"></i>
            <div class="stat-value">{{ $totalVideo }}</div>
            <div class="stat-label">Total Video</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-warning text-dark">
            <i class="bi bi-pencil-square stat-icon"></i>
            <div class="stat-value">{{ $totalTugas }}</div>
            <div class="stat-label">Total Tugas</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-success text-white">
            <i class="bi bi-question-circle stat-icon"></i>
            <div class="stat-value">{{ $totalKuis }}</div>
            <div class="stat-label">Total Kuis</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-file-earmark-text me-2"></i>Materi Terbaru</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Judul</th><th>Kelas</th><th>Tanggal</th></tr></thead>
                    <tbody>
                        @forelse($materiTerbaru as $m)
                            <tr><td>{{ $m->judul }}</td><td>{{ $m->kelas->nama_kelas }}</td><td>{{ $m->created_at->format('d/m/Y') }}</td></tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada materi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil-square me-2"></i>Tugas Terbaru</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Judul</th><th>Kelas</th><th>Deadline</th></tr></thead>
                    <tbody>
                        @forelse($tugasTerbaru as $t)
                            <tr><td>{{ $t->judul }}</td><td>{{ $t->kelas->nama_kelas }}</td><td>{{ $t->deadline->format('d/m/Y') }}</td></tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada tugas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
