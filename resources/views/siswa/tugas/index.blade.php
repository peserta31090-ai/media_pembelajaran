@extends('layouts.siswa')
@section('title', 'Tugas')

@section('content')
<h4 class="page-title">Tugas</h4>

<div class="row g-3">
    @forelse($tugas as $t)
        <div class="col-md-6">
            <div class="card list-item-card h-100">
                <div class="card-body">
                    <h6 class="fw-semibold">{{ $t->judul }}</h6>
                    @if($t->mapel)
                        <span class="badge bg-secondary mb-1">{{ $t->mapel->nama_mapel }}</span>
                    @endif
                    <p class="mb-2 text-muted small">{{ Str::limit($t->deskripsi, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-danger"><i class="bi bi-clock"></i> Deadline: {{ $t->deadline->format('d/m/Y H:i') }}</small>
                        <a href="{{ route('siswa.tugas.show', $t->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> Lihat</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><p class="text-muted">Belum ada tugas untuk kelas Anda.</p></div>
    @endforelse
</div>
@endsection
