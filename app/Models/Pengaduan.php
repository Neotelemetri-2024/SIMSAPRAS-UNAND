<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FiltersSaranaAccess;

class Pengaduan extends Model
{
    use FiltersSaranaAccess;
    use HasFactory;
    protected $table = 'pengaduan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'id_sarana',
        'foto',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    public function sarana()
    {
        return $this->belongsTo(Sarana::class, 'id_sarana');
    }

    public function admins()
    {
        return $this->hasManyThrough(
            User::class,
            Sarana::class,
            'id',
            'id',
            'id_sarana',
            'user_id' 
        )->withPivot('admin_access');
    }
}