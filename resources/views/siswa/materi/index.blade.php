@extends('layouts.siswa')
@section('title', 'Materi Pembelajaran')

@section('content')
<h4 class="page-title">Materi Pembelajaran</h4>

<div class="row g-3">
    @forelse($materi as $m)
        <div class="col-md-6 col-lg-4">
            <div class="card list-item-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-file-earmark-text fs-4 text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold mb-1">{{ $m->judul }}</h6>
                            @if($m->mapel)
                                <span class="badge bg-secondary mb-1">{{ $m->mapel->nama_mapel }}</span>
                            @endif
                            <small class="text-muted d-block mb-2">{{ Str::limit($m->deskripsi, 50) }}</small>
                            <small class="text-muted">Oleh: {{ $m->guru->user->name }}</small>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('siswa.materi.show', $m->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> Lihat</a>
                        <a href="{{ asset('storage/'.$m->file) }}" target="_blank" class="btn btn-sm btn-success"><i class="bi bi-download"></i> Download</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><p class="text-muted">Belum ada materi untuk kelas Anda.</p></div>
    @endforelse
</div>
@endsection
