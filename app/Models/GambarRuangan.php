<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarRuangan extends Model
{
    use HasFactory;
    protected $table = 'gambar_Ruangan';
     protected $fillable = [
        'idRuangan',
        'gambar',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'idRuangan');
    }
}
