<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccess extends Model
{
    protected $table = 'admin_access';
    
    protected $fillable = [
        'user_id',
        'sarana_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }

    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (self::where('sarana_id', $model->sarana_id)->exists()) {
                throw new \Exception("Sarana sudah ditugaskan ke admin lain");
            }
        });
    }
}