<?php

namespace App\Traits;

trait FiltersSaranaAccess
{
    protected function scopeFilterByUserAccess($query, $user)
    {
        if ($user->role === 'admin') {
            if (get_class($this) === 'App\Models\Sarana') {
                return $query->whereHas('admins', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }
            else if (get_class($this) === 'App\Models\Peminjaman') {
                return $query->whereHas('sarana', function($q) use ($user) {
                    $q->whereHas('admins', function($subQ) use ($user) {
                        $subQ->where('user_id', $user->id);
                    });
                });
            }
            else if (get_class($this) === 'App\Models\Pengaduan') {
                return $query->whereHas('sarana', function($q) use ($user) {
                    $q->whereHas('admins', function($subQ) use ($user) {
                        $subQ->where('user_id', $user->id);
                    });
                });
            }
        }
        return $query;
    }
}