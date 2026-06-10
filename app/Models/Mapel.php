<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapels';

    protected $fillable = ['nama_mapel', 'kelas_id', 'guru_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function kuis()
    {
        return $this->hasMany(Kuis::class);
    }

    public function videoPembelajarans()
    {
        return $this->hasMany(VideoPembelajaran::class);
    }
}
