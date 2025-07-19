<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FiltersSaranaAccess;

class Sarana extends Model
{
    use FiltersSaranaAccess;
    use HasFactory;

    protected $fillable = [
        'IdKategori',
        'gambar',
        'deskripsi',
        'nama',
        'isRoom',
        'fasilitas',
        'kapasitas',
        'tariformawa',
        'tarifunit',
        'tarifumum',
        'requiresFaculty',
        'is_hourly_rate',
        'hours_per_unit',
        'status',
    ];
    protected $table = 'sarana';

    public function kategoriSarana()
    {
        return $this->belongsTo(KategoriSarana::class, 'IdKategori');
    }

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class,'idSarana', 'id');
    }

    public function gambarSarana()
    {
        return $this->hasMany(GambarSarana::class, 'idSarana', 'id');
    }

    public function penjaga()
    {
        return $this->hasMany(Penjaga::class, 'idSarana', 'id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'idSarana'); 
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'admin_access', 'sarana_id', 'user_id')
                    ->withTimestamps();
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_sarana', 'id');
    }

    public function canBeAccessedBy(User $user)
    {
        if ($this->requiresFaculty) {
            return $user->isFacultyUser();
        }
        return true;
    }
}