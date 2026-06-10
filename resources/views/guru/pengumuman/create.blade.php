@extends('layouts.guru')
@section('title', 'Buat Pengumuman')

@section('content')
<h4 class="page-title">Buat Pengumuman</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('guru.pengumuman.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Judul *</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Isi *</label>
                <textarea name="isi" class="form-control" rows="6" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Publikasikan</button>
            <a href="{{ route('guru.pengumuman.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
