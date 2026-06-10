@extends('layouts.siswa')
@section('title', 'Nilai')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Rekap Nilai</h4>
    <a href="{{ route('siswa.nilai.cetak') }}" target="_blank" class="btn btn-danger"><i class="bi bi-file-pdf"></i> Cetak PDF</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card bg-info text-white">
            <i class="bi bi-check-circle stat-icon"></i>
            <div class="stat-value">{{ $dikerjakanCount }}/{{ $tugasCount }}</div>
            <div class="stat-label">Tugas Dikerjakan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-success text-white">
            <i class="bi bi-bar-chart stat-icon"></i>
            <div class="stat-value">{{ $rataTugas ? number_format($rataTugas, 1) : '-' }}</div>
            <div class="stat-label">Rata-rata Tugas</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-primary text-white">
            <i class="bi bi-trophy stat-icon"></i>
            <div class="stat-value">{{ $nilaiKuis->count() }}</div>
            <div class="stat-label">Kuis Dikerjakan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-warning text-dark">
            <i class="bi bi-graph-up stat-icon"></i>
            <div class="stat-value">{{ $rataKuis ? number_format($rataKuis, 1) : '-' }}</div>
            <div class="stat-label">Rata-rata Kuis</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Nilai Tugas</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Tugas</th><th>Mapel</th><th>Nilai</th></tr></thead>
                    <tbody>
                        @forelse($nilaiTugas as $n)
                            <tr>
                                <td>{{ $n->tugas->judul }}</td>
                                <td><small class="text-muted">{{ $n->tugas->mapel->nama_mapel ?? '-' }}</small></td>
                                <td><span class="badge bg-{{ $n->nilai >= 70 ? 'success' : 'danger' }}">{{ $n->nilai }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-muted">Belum ada nilai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Nilai Kuis</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Kuis</th><th>Nilai</th></tr></thead>
                    <tbody>
                        @forelse($nilaiKuis as $n)
                            <tr>
                                <td>{{ $n->kuis->judul }}</td>
                                <td><span class="badge bg-{{ $n->nilai >= 70 ? 'success' : 'danger' }}">{{ $n->nilai }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-muted">Belum ada nilai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
