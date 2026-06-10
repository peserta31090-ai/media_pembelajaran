<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalKuis extends Model
{
    protected $table = 'soal_kuis';

    protected $fillable = ['kuis_id', 'pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'jawaban_benar'];

    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }
}
