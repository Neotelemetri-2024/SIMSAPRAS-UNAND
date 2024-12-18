<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarSarana extends Model
{
    protected $table = 'gambar_sarana';

    protected $fillable = [
        'idSarana',
        'gambar'
    ];

    public function sarana()
    {
        return $this->belongsTo(Sarana::class, 'idSarana');
    }
}