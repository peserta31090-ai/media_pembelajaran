@extends('layouts.guru')
@section('title', 'Edit Tugas')

@section('content')
<h4 class="page-title">Edit Tugas</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('guru.tugas.update', $tuga->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Judul *</label>
                <input type="text" name="judul" class="form-control" value="{{ $tuga->judul }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ $tuga->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Mata Pelajaran</label>
                <select name="mapel_id" class="form-select mapel-select">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" data-kelas-id="{{ $mapel->kelas_id }}" {{ $tuga->mapel_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kelas <span class="text-muted">(otomatis dari mapel)</span></label>
                <select name="kelas_id" class="form-select kelas-select" required>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $tuga->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Deadline *</label>
                <input type="datetime-local" name="deadline" class="form-control" value="{{ $tuga->deadline->format('Y-m-d\TH:i') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('guru.tugas.index') }}" class="btn btn-secondary">Batal</a>
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
