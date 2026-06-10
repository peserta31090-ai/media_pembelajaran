@extends('layouts.admin')
@section('title', 'Data Guru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Data Guru</h4>
    <a href="{{ route('admin.guru.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Guru</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="guruTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIP</th>
                    <th>No. HP</th>
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
    $('#guruTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.guru.index") }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'user.name'},
            {data: 'email', name: 'user.email'},
            {data: 'nip', name: 'nip'},
            {data: 'no_hp', name: 'no_hp'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });
});
</script>
@endpush
