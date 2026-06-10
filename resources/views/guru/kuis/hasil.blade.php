@extends('layouts.guru')
@section('title', 'Hasil Kuis')

@section('content')
<h4 class="page-title">Hasil Kuis: {{ $kuis->judul }}</h4>

<div class="card">
    <div class="card-body">
        @if($hasil->count() > 0)
            <table class="table table-hover">
                <thead><tr><th>No</th><th>Nama Siswa</th><th>Nilai</th><th>Tanggal</th></tr></thead>
                <tbody>
                    @foreach($hasil as $i => $h)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $h->siswa->user->name }}</td>
                            <td><span class="badge bg-{{ $h->nilai >= 70 ? 'success' : 'danger' }}">{{ $h->nilai }}</span></td>
                            <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Belum ada siswa yang mengerjakan kuis ini.</p>
        @endif
        <a href="{{ route('guru.kuis.index') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>
@endsection
