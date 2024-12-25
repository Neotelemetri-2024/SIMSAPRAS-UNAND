<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiAdminController extends Controller
{
    public function index()
    {
        $pengguna = auth()->user();
        
        // Get notifications with eager loading for performance
        $unreadNotifications = Notifikasi::with('peminjaman')
            ->where('penerima', $pengguna->id)
            ->where('isRead', false)
            ->latest()
            ->get();
        
        $readNotifications = Notifikasi::with('peminjaman')
            ->where('penerima', $pengguna->id)
            ->where('isRead', true)
            ->latest()
            ->get();
        
        return view('admin.notifikasi', compact('unreadNotifications', 'readNotifications'));
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        try {
            DB::beginTransaction();
            
            // Verify the notification belongs to the authenticated user
            if ($notifikasi->penerima !== auth()->id()) {
                throw new \Exception('Unauthorized access to notification');
            }

            // Only update if not already read
            if (!$notifikasi->isRead) {
                $notifikasi->update(['isRead' => true]);
            }

            DB::commit();
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notification as read'
            ], 500);
        }
    }
}