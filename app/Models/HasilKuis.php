<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilKuis extends Model
{
    protected $table = 'hasil_kuis';

    protected $fillable = ['kuis_id', 'siswa_id', 'nilai'];

    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
