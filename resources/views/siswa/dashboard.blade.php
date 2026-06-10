@extends('layouts.siswa')
@section('title', 'Dashboard Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Dashboard Siswa</h4>
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

@if($pengumuman->count() > 0)
<div class="card mb-4">
    <div class="card-header"><i class="bi bi-megaphone me-2"></i>Pengumuman</div>
    <div class="card-body">
        @foreach($pengumuman as $p)
            <div class="mb-2 pb-2 border-bottom">
                <strong>{{ $p->judul }}</strong>
                <p class="mb-0">{{ $p->isi }}</p>
                <small class="text-muted">{{ $p->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-file-earmark-text me-2"></i>Materi Terbaru</div>
            <div class="card-body">
                @forelse($materi as $m)
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <strong>{{ $m->judul }}</strong><br>
                            <small class="text-muted">{{ $m->guru->user->name }}</small>
                        </div>
                        <a href="{{ route('siswa.materi.show', $m->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                    </div>
                @empty
                    <p class="text-muted">Belum ada materi.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil-square me-2"></i>Tugas Terbaru</div>
            <div class="card-body">
                @forelse($tugas as $t)
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <strong>{{ $t->judul }}</strong><br>
                            <small class="text-muted">Deadline: {{ $t->deadline->format('d/m/Y H:i') }}</small>
                        </div>
                        <a href="{{ route('siswa.tugas.show', $t->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-eye"></i></a>
                    </div>
                @empty
                    <p class="text-muted">Belum ada tugas.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
