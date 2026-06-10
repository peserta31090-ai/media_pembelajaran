@extends('layouts.admin')
@section('title', 'Edit Pengumuman')

@section('content')
<h4 class="page-title">Edit Pengumuman</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $pengumuman->judul) }}" required>
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" rows="6" required>{{ old('isi', $pengumuman->isi) }}</textarea>
                @error('isi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
