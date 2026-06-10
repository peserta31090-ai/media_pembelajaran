@extends('layouts.guru')
@section('title', 'Kuis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Kuis</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kuisModal"><i class="bi bi-plus-lg"></i> Tambah Kuis</button>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="kuisTable">
            <thead><tr><th>No</th><th>Judul</th><th>Mapel</th><th>Kelas</th><th>Jumlah Soal</th><th>Aksi</th></tr></thead>
        </table>
    </div>
</div>

<div class="modal fade" id="kuisModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('guru.kuis.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kuis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul *</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-select mapel-select">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}" data-kelas-id="{{ $mapel->kelas_id }}">{{ $mapel->nama_mapel }} - {{ $mapel->kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas <span class="text-muted">(otomatis dari mapel)</span></label>
                        <select name="kelas_id" class="form-select kelas-select" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
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
$(document).ready(function() {
    $('#kuisTable').DataTable({
        processing: true, serverSide: true,
        ajax: '{{ route("guru.kuis.index") }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'judul', name: 'judul'},
            {data: 'mapel', name: 'mapel.nama_mapel'},
            {data: 'kelas.nama_kelas', name: 'kelas.nama_kelas'},
            {data: 'jumlah_soal', name: 'jumlah_soal', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
    });

    $('.mapel-select').on('change', function() {
        var kelasId = $(this).find(':selected').data('kelas-id');
        var $kelas = $(this).closest('form').find('.kelas-select');
        if (kelasId) {
            $kelas.val(kelasId).prop('disabled', true);
        } else {
            $kelas.val('').prop('disabled', false);
        }
    });
});
</script>
@endpush
