<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'gurus';

    protected $fillable = ['user_id', 'nip', 'alamat', 'no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
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
