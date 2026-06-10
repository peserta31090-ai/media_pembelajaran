<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $table = 'kuis';

    protected $fillable = ['judul', 'kelas_id', 'guru_id', 'mapel_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function soalKuis()
    {
        return $this->hasMany(SoalKuis::class);
    }

    public function hasilKuis()
    {
        return $this->hasMany(HasilKuis::class);
    }
}
