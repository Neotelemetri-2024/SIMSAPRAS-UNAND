<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityUsage extends Model
{
    use HasFactory;

    protected $table = 'facility_usage';
    
    protected $fillable = [
        'idSarana',
        'idRuangan',
        'tanggal',
        'jam_terpakai'
    ];

    public function sarana()
    {
        return $this->belongsTo(Sarana::class, 'idSarana');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'idRuangan');
    }
}