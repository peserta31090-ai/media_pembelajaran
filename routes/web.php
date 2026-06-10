<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Guru\KuisController;
use App\Http\Controllers\Guru\MateriController;
use App\Http\Controllers\Guru\TugasController;
use App\Http\Controllers\Guru\VideoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\NilaiController;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Route;

// ========== AUTH ROUTES (Breeze) ==========
Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($role === 'guru') {
            return redirect()->route('guru.dashboard');
        }
        if ($role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        return redirect('/');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    // ========== ADMIN ROUTES ==========
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('guru', GuruController::class);
        Route::resource('siswa', SiswaController::class);
        Route::get('siswa-import', [SiswaController::class, 'importForm'])->name('siswa.import');
        Route::post('siswa-import', [SiswaController::class, 'import'])->name('siswa.import.process');
        Route::resource('kelas', KelasController::class)->except(['create', 'show', 'edit']);
        Route::get('kelas/{kela}/mapel', [MapelController::class, 'index'])->name('mapel.index');
        Route::post('kelas/{kela}/mapel', [MapelController::class, 'store'])->name('mapel.store');
        Route::put('kelas/{kela}/mapel/{mapel}', [MapelController::class, 'update'])->name('mapel.update');
        Route::delete('kelas/{kela}/mapel/{mapel}', [MapelController::class, 'destroy'])->name('mapel.destroy');
        Route::resource('pengumuman', PengumumanController::class);
    });

    // ========== GURU ROUTES ==========
    Route::prefix('guru')->name('guru.')->middleware(['role:guru'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('materi', MateriController::class)->except(['create', 'show']);
        Route::resource('video', VideoController::class)->except(['create', 'show']);
        Route::resource('tugas', TugasController::class)->except(['create', 'show']);

        Route::get('tugas/{tuga}/pengumpulan', [TugasController::class, 'pengumpulan'])->name('tugas.pengumpulan');
        Route::post('pengumpulan/{pengumpulanTuga}/nilai', [TugasController::class, 'nilai'])->name('pengumpulan.nilai');

        Route::resource('kuis', KuisController::class)->except(['create', 'show'])->parameters(['kuis' => 'kuis']);
        Route::get('kuis/{kuis}/soal', [KuisController::class, 'soal'])->name('kuis.soal');
        Route::post('kuis/{kuis}/soal', [KuisController::class, 'storeSoal'])->name('kuis.soal.store');
        Route::delete('soal/{soalKuis}', [KuisController::class, 'destroySoal'])->name('soal.destroy');
        Route::get('kuis/{kuis}/hasil', [KuisController::class, 'hasil'])->name('kuis.hasil');

        Route::get('pengumuman', [App\Http\Controllers\Guru\PengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('pengumuman/create', [App\Http\Controllers\Guru\PengumumanController::class, 'create'])->name('pengumuman.create');
        Route::post('pengumuman', [App\Http\Controllers\Guru\PengumumanController::class, 'store'])->name('pengumuman.store');
    });

    // ========== SISWA ROUTES ==========
    Route::prefix('siswa')->name('siswa.')->middleware(['role:siswa'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');

        Route::get('materi', [App\Http\Controllers\Siswa\MateriController::class, 'index'])->name('materi.index');
        Route::get('materi/{materi}', [App\Http\Controllers\Siswa\MateriController::class, 'show'])->name('materi.show');

        Route::get('video', [App\Http\Controllers\Siswa\VideoController::class, 'index'])->name('video.index');

        Route::get('tugas', [App\Http\Controllers\Siswa\TugasController::class, 'index'])->name('tugas.index');
        Route::get('tugas/{tuga}', [App\Http\Controllers\Siswa\TugasController::class, 'show'])->name('tugas.show');
        Route::post('tugas/{tuga}/upload', [App\Http\Controllers\Siswa\TugasController::class, 'upload'])->name('tugas.upload');

        Route::get('kuis', [App\Http\Controllers\Siswa\KuisController::class, 'index'])->name('kuis.index');
        Route::get('kuis/{kuis}/mulai', [App\Http\Controllers\Siswa\KuisController::class, 'mulai'])->name('kuis.mulai');
        Route::post('kuis/{kuis}/submit', [App\Http\Controllers\Siswa\KuisController::class, 'submit'])->name('kuis.submit');
        Route::get('kuis/{kuis}/hasil', [App\Http\Controllers\Siswa\KuisController::class, 'hasil'])->name('kuis.hasil');

        Route::get('nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('nilai/cetak', [NilaiController::class, 'cetakPdf'])->name('nilai.cetak');

        Route::get('pengumuman', function () {
            $pengumuman = Pengumuman::latest()->get();

            return view('siswa.pengumuman.index', compact('pengumuman'));
        })->name('pengumuman.index');
    });
});

require __DIR__.'/auth.php';
