@extends('layouts.siswa')
@section('title', 'Kuis')

@section('content')
<h4 class="page-title">Kuis</h4>

<div class="row g-3">
    @forelse($kuis as $k)
        @php
            $selesai = App\Models\HasilKuis::where('kuis_id', $k->id)->where('siswa_id', auth()->user()->siswa->id)->first();
        @endphp
        <div class="col-md-6 col-lg-4">
            <div class="card list-item-card h-100">
                <div class="card-body">
                    <h6 class="fw-semibold">{{ $k->judul }}</h6>
                    @if($k->mapel)
                        <span class="badge bg-secondary mb-1">{{ $k->mapel->nama_mapel }}</span>
                    @endif
                    <small class="text-muted d-block mb-2">Oleh: {{ $k->guru->user->name }}</small>
                    @if($selesai)
                        <span class="badge bg-success mb-2">Nilai: {{ $selesai->nilai }}</span>
                        <a href="{{ route('siswa.kuis.hasil', $k->id) }}" class="btn btn-sm btn-info w-100">Lihat Hasil</a>
                    @else
                        <a href="{{ route('siswa.kuis.mulai', $k->id) }}" class="btn btn-sm btn-primary w-100"><i class="bi bi-play"></i> Kerjakan</a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><p class="text-muted">Belum ada kuis untuk kelas Anda.</p></div>
    @endforelse
</div>
@endsection
