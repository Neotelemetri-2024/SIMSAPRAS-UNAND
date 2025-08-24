<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekening';
    
    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik',
        'is_aktif'
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public static function getRekeningAktif()
    {
        return self::where('is_aktif', true)->first();
    }
}
