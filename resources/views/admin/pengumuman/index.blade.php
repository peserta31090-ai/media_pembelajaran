@extends('layouts.admin')
@section('title', 'Pengumuman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Pengumuman</h4>
    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Buat Pengumuman</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="pengumumanTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#pengumumanTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.pengumuman.index") }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'judul', name: 'judul'},
            {data: 'isi', name: 'isi'},
            {data: 'tanggal', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
    });
});
</script>
@endpush
