@extends('layouts.guru')
@section('title', 'Edit Video')

@section('content')
<h4 class="page-title">Edit Video</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('guru.video.update', $video->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Judul *</label>
                <input type="text" name="judul" class="form-control" value="{{ $video->judul }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mata Pelajaran</label>
                <select name="mapel_id" class="form-select mapel-select">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" data-kelas-id="{{ $mapel->kelas_id }}" {{ $video->mapel_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kelas <span class="text-muted">(otomatis dari mapel)</span></label>
                <select name="kelas_id" class="form-select kelas-select" required>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $video->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Link Video *</label>
                <input type="url" name="link_video" class="form-control" value="{{ $video->link_video }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('guru.video.index') }}" class="btn btn-secondary">Batal</a>
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
