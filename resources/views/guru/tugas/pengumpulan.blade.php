@extends('layouts.guru')
@section('title', 'Pengumpulan Tugas')

@section('content')
<h4 class="page-title">Pengumpulan Tugas: {{ $tuga->judul }}</h4>

<div class="card">
    <div class="card-body">
        @if($pengumpulan->count() > 0)
            <table class="table table-hover">
                <thead><tr><th>No</th><th>Nama Siswa</th><th>File</th><th>Tanggal</th><th>Nilai</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($pengumpulan as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->siswa->user->name }}</td>
                            <td><a href="{{ asset('storage/'.$p->file_jawaban) }}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-download"></i> Download</a></td>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($p->nilai !== null)
                                    <span class="badge bg-success">{{ $p->nilai }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Dinilai</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="beriNilai({{ $p->id }}, {{ $p->nilai ?? 0 }})"><i class="bi bi-pencil"></i> Nilai</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Belum ada pengumpulan tugas.</p>
        @endif
        <a href="{{ route('guru.tugas.index') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="modal fade" id="nilaiModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="nilaiForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Beri Nilai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nilai (0-100)</label>
                    <input type="number" name="nilai" id="nilaiInput" class="form-control" min="0" max="100" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function beriNilai(id, nilai) {
    document.getElementById('nilaiInput').value = nilai;
    document.getElementById('nilaiForm').action = '/guru/pengumpulan/' + id + '/nilai';
    new bootstrap.Modal(document.getElementById('nilaiModal')).show();
}
</script>
@endpush
