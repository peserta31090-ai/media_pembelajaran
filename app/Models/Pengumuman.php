<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumen';

    protected $fillable = ['judul', 'isi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
