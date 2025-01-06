<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     *u The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kontak',
        'email_verified_at'
    ];
   public function hasAnyRole($roles): bool
    {
        // Jika string diberikan, ubah menjadi array
        if (is_string($roles)) {
            $roles = [$roles];
        }

        return in_array($this->role, $roles);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'idUser');
    }

      // Relasi untuk peminjaman yang disetujui oleh user ini
    public function peminjamanDisetujui()
    {
        return $this->hasMany(Peminjaman::class, 'disetujui_oleh');
    }

    // Relasi untuk peminjaman yang ditolak oleh user ini
    public function peminjamanDitolak()
    {
        return $this->hasMany(Peminjaman::class, 'ditolak_oleh');
    }

    // Relasi untuk peminjaman yang dibatalkan oleh user ini
    public function peminjamanDibatalkan()
    {
        return $this->hasMany(Peminjaman::class, 'dibatalkan_oleh');
    }
     public function peminjamanDiproses()
    {
        return $this->hasMany(Peminjaman::class, 'diproses_oleh');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'penerima');
    }

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class, 'penulis');
    }

    public function beamsInterest()
    {
        // Generate interest berdasarkan user ID dan role
        $interests = ['user-' . $this->id];
        
        // Tambahkan interest berdasarkan role
        if ($this->role) {
            $interests[] = 'role-' . $this->role;
        }
        
        return $interests;
    }

    public function routeNotificationForBeams()
    {
        return $this->beamsInterest();
    }

    public function saranaAccess()
    {
        return $this->belongsToMany(Sarana::class, 'admin_access', 'user_id', 'sarana_id')
                    ->withTimestamps();
    }

    // Method untuk mengecek akses ke sarana tertentu
    public function canAccessSarana($saranaId): bool
    {
        if ($this->role === 'superadmin') {
            return true;
        }
        
        if ($this->role === 'admin') {
            return $this->saranaAccess()->where('sarana_id', $saranaId)->exists();
        }
        
        return false;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}