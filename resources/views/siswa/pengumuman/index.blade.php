@extends('layouts.siswa')
@section('title', 'Pengumuman')

@section('content')
<h4 class="page-title">Pengumuman</h4>

<div class="row g-3">
    @forelse($pengumuman as $p)
        <div class="col-12">
            <div class="card list-item-card">
                <div class="card-body">
                    <h5 class="card-title">{{ $p->judul }}</h5>
                    <p class="card-text">{{ $p->isi }}</p>
                    <small class="text-muted">{{ $p->created_at->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><p class="text-muted">Belum ada pengumuman.</p></div>
    @endforelse
</div>
@endsection
