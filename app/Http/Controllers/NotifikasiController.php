<?php
namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $pengguna = auth()->user();
        
        // Get notifications through peminjaman relationship
        $unreadNotifications = Notifikasi::whereHas('peminjaman', function($query) use ($pengguna) {
            $query->where('idUser', $pengguna->id);
        })->where('isRead', false)->latest()->get();
        
        $readNotifications = Notifikasi::whereHas('peminjaman', function($query) use ($pengguna) {
            $query->where('idUser', $pengguna->id);
        })->where('isRead', true)->latest()->get();
        
        return view('notif', compact('unreadNotifications', 'readNotifications'));
    }
}