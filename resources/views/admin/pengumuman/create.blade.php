@extends('layouts.admin')
@section('title', 'Buat Pengumuman')

@section('content')
<h4 class="page-title">Buat Pengumuman</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.pengumuman.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" rows="6" required>{{ old('isi') }}</textarea>
                @error('isi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Publikasikan</button>
            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
