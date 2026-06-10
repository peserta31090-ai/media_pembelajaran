@extends(auth()->user()->role == 'admin' ? 'layouts.admin' : (auth()->user()->role == 'guru' ? 'layouts.guru' : 'layouts.siswa'))
@section('title', 'Profile')

@section('content')
<h4 class="page-title">Profile</h4>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Edit Profile</div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama *</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Ubah Password</div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini *</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
