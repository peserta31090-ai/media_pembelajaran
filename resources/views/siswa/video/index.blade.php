@extends('layouts.siswa')
@section('title', 'Video Pembelajaran')

@section('content')
<h4 class="page-title">Video Pembelajaran</h4>

<div class="row g-3">
    @forelse($video as $v)
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="fw-semibold">{{ $v->judul }}</h6>
                    @if($v->mapel)
                        <span class="badge bg-secondary mb-1">{{ $v->mapel->nama_mapel }}</span>
                    @endif
                    <small class="text-muted d-block mb-2">Oleh: {{ $v->guru->user->name }}</small>
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe src="{{ $v->link_video }}" title="{{ $v->judul }}" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><p class="text-muted">Belum ada video untuk kelas Anda.</p></div>
    @endforelse
</div>
@endsection
