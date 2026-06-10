@extends('layouts.guru')
@section('title', 'Pengumuman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Pengumuman</h4>
    <a href="{{ route('guru.pengumuman.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Buat Pengumuman</a>
</div>

<div class="row g-3">
    @forelse($pengumuman as $p)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $p->judul }}</h5>
                    <p class="card-text">{{ $p->isi }}</p>
                    <small class="text-muted">{{ $p->created_at->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-muted">Belum ada pengumuman.</p>
        </div>
    @endforelse
</div>
@endsection
