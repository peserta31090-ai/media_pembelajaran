@extends('layouts.admin')
@section('title', 'Import Data Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Import Data Siswa</h4>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="alert alert-primary">
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-info-circle fs-4 flex-shrink-0 mt-1"></i>
                            <div>
                                <strong>Petunjuk Import Data Siswa</strong>
                                <ol class="mb-0 mt-1 ps-3">
                                    <li>Siapkan file Excel (.xlsx, .xls) atau CSV dengan kolom <strong>Nama</strong> dan <strong>NIS</strong>.</li>
                                    <li>Baris pertama harus merupakan header (judul kolom).</li>
                                    <li>Email akan dibuat otomatis: <code>nama.nis@siswa.sch.id</code></li>
                                    <li>Password default: <strong>NIS</strong> (atau isi kolom password di bawah jika ingin berbeda).</li>
                                    <li>Siswa akan ditempatkan di kelas yang dipilih.</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Kelas <span class="text-danger">*</span></label>
                        <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Excel / CSV <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv,.txt" required>
                        @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Format: .xlsx, .xls, .csv</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Default <small class="text-muted">(opsional, jika kosong pakai NIS)</small></label>
                        <input type="text" name="default_password" class="form-control" value="{{ old('default_password') }}" placeholder="Kosongkan untuk menggunakan NIS sebagai password">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-upload"></i> Import Data</button>
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Contoh Format File</div>
            <div class="card-body">
                <p class="small text-muted mb-2">Buat file Excel/CSV dengan kolom berikut:</p>
                <table class="table table-bordered table-sm small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>NIS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Andi Pratama</td><td>2024001</td></tr>
                        <tr><td>Siti Nurhaliza</td><td>2024002</td></tr>
                        <tr><td>Budi Santoso</td><td>2024003</td></tr>
                    </tbody>
                </table>
                <a href="#" id="downloadTemplate" class="btn btn-sm btn-outline-primary mt-3">
                    <i class="bi bi-download"></i> Download Template CSV
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('downloadTemplate')?.addEventListener('click', function(e) {
    e.preventDefault();
    const csv = 'Nama,NIS\n" Andi Pratama",2024001\n"Siti Nurhaliza",2024002\n"Budi Santoso",2024003\n';
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'template_import_siswa.csv';
    link.click();
});
</script>
@endpush
