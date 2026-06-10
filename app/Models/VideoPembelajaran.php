<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoPembelajaran extends Model
{
    protected $table = 'video_pembelajarans';

    protected $fillable = ['judul', 'link_video', 'kelas_id', 'guru_id', 'mapel_id'];

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
}
