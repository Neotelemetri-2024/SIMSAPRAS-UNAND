<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $fillable = [
        'judul',
        'isi',
        'penulis'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'penulis');
    }
}