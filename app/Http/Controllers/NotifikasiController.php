<?php
namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $pengguna = auth()->user();
        
        $unreadNotifications = Notifikasi::where('penerima', $pengguna->id)
            ->where('isRead', false)
            ->latest()
            ->get();
        
        $readNotifications = Notifikasi::where('penerima', $pengguna->id)
            ->where('isRead', true)
            ->latest()
            ->get();
        
        return view('notif', compact('unreadNotifications', 'readNotifications'));
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        $notifikasi->update(['isRead' => true]);
        return response()->json(['success' => true]);
    }
}