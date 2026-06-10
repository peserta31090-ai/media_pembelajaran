@extends('layouts.admin')
@section('title', 'Data Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Data Siswa</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.siswa.import') }}" class="btn btn-success"><i class="bi bi-upload"></i> Import</a>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Siswa</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="siswaTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIS</th>
                    <th>Kelas</th>
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
    $('#siswaTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.siswa.index") }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'user.name'},
            {data: 'email', name: 'user.email'},
            {data: 'nis', name: 'nis'},
            {data: 'kelas', name: 'kelas.nama_kelas'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });
});
</script>
@endpush
