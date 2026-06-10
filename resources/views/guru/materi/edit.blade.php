@extends('layouts.guru')
@section('title', 'Edit Materi')

@section('content')
<h4 class="page-title">Edit Materi</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('guru.materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Judul *</label>
                <input type="text" name="judul" class="form-control" value="{{ $materi->judul }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ $materi->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Mata Pelajaran</label>
                <select name="mapel_id" class="form-select mapel-select">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" data-kelas-id="{{ $mapel->kelas_id }}" {{ $materi->mapel_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kelas <span class="text-muted">(otomatis dari mapel)</span></label>
                <select name="kelas_id" class="form-select kelas-select" required>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $materi->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">File <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx">
                <small class="text-muted">File saat ini: <a href="{{ asset('storage/'.$materi->file) }}" target="_blank">{{ basename($materi->file) }}</a></small>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('guru.materi.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.mapel-select').on('change', function() {
        var kelasId = $(this).find(':selected').data('kelas-id');
        var $kelas = $(this).closest('form').find('.kelas-select');
        if (kelasId) {
            $kelas.val(kelasId).prop('disabled', true);
        } else {
            $kelas.val('').prop('disabled', false);
        }
    });

    var initialKelasId = $('.mapel-select').find(':selected').data('kelas-id');
    if (initialKelasId) {
        $('.kelas-select').val(initialKelasId).prop('disabled', true);
    }
});
</script>
@endpush
