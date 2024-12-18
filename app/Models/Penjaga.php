<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjaga extends Model
{
    protected $fillable = [
        'idSarana',
        'kontak',
        'nama'
    ];
    protected $table = 'penjaga';

    public function sarana()
    {
        return $this->belongsTo(Sarana::class, 'idSarana');
    }
}