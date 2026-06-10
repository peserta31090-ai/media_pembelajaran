@extends('layouts.guru')
@section('title', 'Soal Kuis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Soal Kuis: {{ $kuis->judul }}</h4>
    <div>
        <a href="{{ route('guru.kuis.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Tambah Soal</div>
            <div class="card-body">
                <form action="{{ route('guru.kuis.soal.store', $kuis->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan *</label>
                        <textarea name="pertanyaan" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Opsi A *</label>
                        <input type="text" name="opsi_a" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Opsi B *</label>
                        <input type="text" name="opsi_b" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Opsi C *</label>
                        <input type="text" name="opsi_c" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Opsi D *</label>
                        <input type="text" name="opsi_d" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jawaban Benar *</label>
                        <select name="jawaban_benar" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tambah Soal</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Daftar Soal ({{ $soal->count() }})</div>
            <div class="card-body">
                @forelse($soal as $i => $s)
                    <div class="mb-3 p-3 border rounded">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $i + 1 }}. {{ $s->pertanyaan }}</strong>
                            <form action="{{ route('guru.soal.destroy', $s->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus soal ini?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                        <div class="mt-2">
                            <span class="badge bg-{{ $s->jawaban_benar == 'a' ? 'primary' : 'secondary' }}">A. {{ $s->opsi_a }}</span>
                            <span class="badge bg-{{ $s->jawaban_benar == 'b' ? 'primary' : 'secondary' }}">B. {{ $s->opsi_b }}</span>
                            <span class="badge bg-{{ $s->jawaban_benar == 'c' ? 'primary' : 'secondary' }}">C. {{ $s->opsi_c }}</span>
                            <span class="badge bg-{{ $s->jawaban_benar == 'd' ? 'primary' : 'secondary' }}">D. {{ $s->opsi_d }}</span>
                        </div>
                        <small class="text-success">Jawaban: {{ strtoupper($s->jawaban_benar) }}</small>
                    </div>
                @empty
                    <p class="text-muted">Belum ada soal. Tambah soal di samping.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
