@extends('layouts.siswa')
@section('title', $tuga->judul)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">{{ $tuga->judul }}</h4>
    <a href="{{ route('siswa.tugas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <p>{{ $tuga->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                <small class="text-danger"><i class="bi bi-clock"></i> Deadline: {{ $tuga->deadline->format('d/m/Y H:i') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Upload Tugas</div>
            <div class="card-body">
                @if($pengumpulan)
                    <div class="alert alert-success">
                        Tugas sudah dikumpulkan.<br>
                        <a href="{{ asset('storage/'.$pengumpulan->file_jawaban) }}" target="_blank" class="btn btn-sm btn-primary mt-2"><i class="bi bi-download"></i> Lihat File</a>
                        @if($pengumpulan->nilai !== null)
                            <hr>
                            <strong>Nilai: </strong><span class="badge bg-success fs-6">{{ $pengumpulan->nilai }}</span>
                        @endif
                    </div>
                @endif
                <form action="{{ route('siswa.tugas.upload', $tuga->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">File (PDF, DOC, DOCX) *</label>
                        <input type="file" name="file_jawaban" class="form-control" accept=".pdf,.doc,.docx" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-upload"></i> Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
