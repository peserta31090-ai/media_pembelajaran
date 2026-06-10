@extends('layouts.admin')
@section('title', 'Data Kelas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Data Kelas</h4>
</div>

<div class="row g-3">
    @foreach($kelas as $k)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-1">{{ $k->nama_kelas }}</h5>
                            <small class="text-muted">
                                <i class="bi bi-people me-1"></i>{{ $k->siswas_count }} Siswa
                            </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.mapel.index', $k->id) }}"><i class="bi bi-book me-2"></i>Kelola Mapel</a></li>
                                <li><button class="dropdown-item" onclick="editKelas({{ $k->id }}, '{{ $k->nama_kelas }}')"><i class="bi bi-pencil me-2"></i>Edit</button></li>
                                <li>
                                    <button class="dropdown-item text-danger" onclick="confirmDelete({{ $k->id }})"><i class="bi bi-trash me-2"></i>Hapus</button>
                                    <form id="delete-form-{{ $k->id }}" action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="badge bg-primary me-2">
                            <i class="bi bi-book-half me-1"></i>{{ $k->mapels_count }} Mapel
                        </div>
                        <div class="badge bg-success">
                            <i class="bi bi-clipboard-check me-1"></i>{{ $k->materis_count + $k->tugas_count + $k->kuis_count }} Konten
                        </div>
                    </div>

                    <button class="btn btn-sm btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#mapel-{{ $k->id }}">
                        <i class="bi bi-chevron-down me-1"></i>Lihat Mapel
                    </button>

                    <!-- Expandable Mapel List -->
                    <div class="collapse mt-3" id="mapel-{{ $k->id }}">
                        <div class="border-top pt-3">
                            @php
                                $mapels = $k->mapels()->withCount('materis', 'tugas', 'kuis')->get();
                            @endphp
                            
                            @if($mapels->count() > 0)
                                @foreach($mapels as $mapel)
                                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                        <div>
                                            <small class="fw-semibold">{{ $mapel->nama_mapel }}</small>
                                            <br>
                                            <small class="text-muted">
                                                {{ $mapel->materis_count }} Materi • 
                                                {{ $mapel->tugas_count }} Tugas • 
                                                {{ $mapel->kuis_count }} Kuis
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted mb-0"><small>Belum ada mapel</small></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="kelasModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="kelasForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Edit Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" placeholder="Nama Kelas" required>
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
function editKelas(id, nama) {
    document.getElementById('modalTitle').textContent = 'Edit Kelas';
    document.getElementById('nama_kelas').value = nama;
    const form = document.getElementById('kelasForm');
    form.action = '/admin/kelas/' + id;
    form.querySelector('input[name="_method"]')?.remove();
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = '_method';
    input.value = 'PUT';
    form.appendChild(input);
    new bootstrap.Modal(document.getElementById('kelasModal')).show();
}

document.getElementById('kelasModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('modalTitle').textContent = 'Tambah Kelas';
    document.getElementById('kelasForm').action = '{{ route("admin.kelas.store") }}';
    document.getElementById('kelasForm').querySelector('input[name="_method"]')?.remove();
    document.getElementById('nama_kelas').value = '';
});

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

