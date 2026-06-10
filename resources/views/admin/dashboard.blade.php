@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Dashboard Admin</h4>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-lg-2">
        <div class="stat-card bg-primary text-white">
            <i class="bi bi-person-badge stat-icon"></i>
            <div class="stat-value">{{ $totalGuru }}</div>
            <div class="stat-label">Total Guru</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card bg-success text-white">
            <i class="bi bi-people stat-icon"></i>
            <div class="stat-value">{{ $totalSiswa }}</div>
            <div class="stat-label">Total Siswa</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card bg-warning text-dark">
            <i class="bi bi-file-earmark-text stat-icon"></i>
            <div class="stat-value">{{ $totalMateri }}</div>
            <div class="stat-label">Total Materi</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card bg-danger text-white">
            <i class="bi bi-play-circle stat-icon"></i>
            <div class="stat-value">{{ $totalVideo }}</div>
            <div class="stat-label">Total Video</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card bg-info text-white">
            <i class="bi bi-pencil-square stat-icon"></i>
            <div class="stat-value">{{ $totalTugas }}</div>
            <div class="stat-label">Total Tugas</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card bg-secondary text-white">
            <i class="bi bi-question-circle stat-icon"></i>
            <div class="stat-value">{{ $totalKuis }}</div>
            <div class="stat-label">Total Kuis</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2"></i>Statistik Per Kelas
            </div>
            <div class="card-body">
                <canvas id="kelasChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-megaphone me-2"></i>Pengumuman Terbaru
            </div>
            <div class="card-body">
                @forelse($pengumuman as $p)
                    <div class="mb-2 pb-2 border-bottom">
                        <strong>{{ $p->judul }}</strong>
                        <p class="mb-0 small text-muted">{{ Str::limit($p->isi, 80) }}</p>
                        <small class="text-muted">{{ $p->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <p class="text-muted mb-0">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-badge me-2"></i>Guru Terbaru
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruTerbaru as $g)
                            <tr>
                                <td>{{ $g->user->name }}</td>
                                <td>{{ $g->user->email }}</td>
                                <td>{{ $g->nip }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-people me-2"></i>Siswa Terbaru
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaTerbaru as $s)
                            <tr>
                                <td>{{ $s->user->name }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->kelas->nama_kelas }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('kelasChart')?.getContext('2d');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($kelasList->pluck('nama_kelas')) !!},
            datasets: [{
                label: 'Jumlah Siswa',
                data: {!! json_encode($kelasList->pluck('siswas_count')) !!},
                backgroundColor: '#0D6EFD',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
}
</script>
@endpush
