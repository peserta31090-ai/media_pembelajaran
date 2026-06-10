@extends('layouts.admin')
@section('title', 'Kelola Mapel - ' . $kela->nama_kelas)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.kelas.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
        <h4 class="page-title mb-0">Mapel - Kelas {{ $kela->nama_kelas }}</h4>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mapelModal">
        <i class="bi bi-plus-lg"></i> Tambah Mapel
    </button>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Mapel</th>
                    <th>Guru</th>
                    <th>Materi</th>
                    <th>Tugas</th>
                    <th>Kuis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mapels as $mapel)
                    <tr>
                        <td>
                            <span class="fw-semibold">{{ $mapel->nama_mapel }}</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $mapel->guru->user->name }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $mapel->materis_count }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning">{{ $mapel->tugas_count }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $mapel->kuis_count }}</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="editMapel({{ $mapel->id }}, '{{ $mapel->nama_mapel }}', {{ $mapel->guru_id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $mapel->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $mapel->id }}" action="{{ route('admin.mapel.destroy', [$kela->id, $mapel->id]) }}" method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <p class="text-muted mb-0">Belum ada mapel</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah/Edit Mapel -->
<div class="modal fade" id="mapelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="mapelForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Mapel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_mapel" class="form-label">Nama Mapel</label>
                        <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" placeholder="Nama Mapel" required>
                    </div>
                    <div class="mb-3">
                        <label for="guru_id" class="form-label">Guru</label>
                        <select name="guru_id" id="guru_id" class="form-select" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->user->name }}</option>
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
function editMapel(id, nama, guruId) {
    document.getElementById('modalTitle').textContent = 'Edit Mapel';
    document.getElementById('nama_mapel').value = nama;
    document.getElementById('guru_id').value = guruId;
    const form = document.getElementById('mapelForm');
    form.action = '{{ route("admin.mapel.update", [$kela->id, ""]) }}'.replace(/\/$/, '') + '/' + id;
    form.querySelector('input[name="_method"]')?.remove();
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = '_method';
    input.value = 'PUT';
    form.appendChild(input);
    new bootstrap.Modal(document.getElementById('mapelModal')).show();
}

document.getElementById('mapelModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('modalTitle').textContent = 'Tambah Mapel';
    document.getElementById('mapelForm').action = '{{ route("admin.mapel.store", $kela->id) }}';
    document.getElementById('mapelForm').querySelector('input[name="_method"]')?.remove();
    document.getElementById('nama_mapel').value = '';
    document.getElementById('guru_id').value = '';
});

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus mapel ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
