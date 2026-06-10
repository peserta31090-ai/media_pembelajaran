<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas'];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function mapels()
    {
        return $this->hasMany(Mapel::class);
    }

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    public function videoPembelajarans()
    {
        return $this->hasMany(VideoPembelajaran::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function kuis()
    {
        return $this->hasMany(Kuis::class);
    }
}
