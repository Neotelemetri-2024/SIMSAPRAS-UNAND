<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
        'kontak'
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