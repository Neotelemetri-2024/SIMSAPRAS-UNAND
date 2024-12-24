<?php

namespace App\Services;

use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Pusher\PushNotifications\PushNotifications;

class NotificationService
{
    protected $beams;

    public function __construct(PushNotifications $beams)
    {
        $this->beams = $beams;
    }

    // Kirim ke user spesifik
    public function sendToUser(Peminjaman $peminjaman, $title, $message)
    {
        try {
            // Simpan ke database
            Notifikasi::create([
                'idPeminjaman' => $peminjaman->id,
                'judul' => $title,
                'isi' => $message,
                'isRead' => false,
                'userId' => $peminjaman->user->id
            ]);

            // Kirim via Beams ke user spesifik
            $this->beams->publishToUsers(
                [(string)$peminjaman->user->id],
                [
                    'web' => [
                        'notification' => [
                            'title' => $title,
                            'body' => $message,
                            'deep_link' => route('peminjaman.detail', $peminjaman->id),
                            'data' => [
                                'peminjaman_id' => $peminjaman->id,
                                'type' => 'user_notification',
                                'status' => $peminjaman->status
                            ]
                        ]
                    ]
                ]
            );

            return true;
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
            return false;
        }
    }

    // Kirim ke semua (broadcast)
    public function sendToAll($title, $message, $data = [])
    {
        try {
            $this->beams->publishToInterests(
                ['all-users'],
                [
                    'web' => [
                        'notification' => [
                            'title' => $title,
                            'body' => $message,
                            'data' => array_merge(['type' => 'broadcast'], $data)
                        ]
                    ]
                ]
            );
            return true;
        } catch (\Exception $e) {
            \Log::error('Broadcast notification error: ' . $e->getMessage());
            return false;
        }
    }

    // Kirim ke admin dengan interest
    public function sendToAdmin(Peminjaman $peminjaman, $title, $message)
    {
        try {
            // Simpan ke database
            Notifikasi::create([
                'idPeminjaman' => $peminjaman->id,
                'judul' => $title,
                'isi' => $message,
                'isRead' => false,
                'type' => 'admin'
            ]);

            // Broadcast ke admin
            $this->beams->publishToInterests(
                ['peminjamanadmin'],
                [
                    'web' => [
                        'notification' => [
                            'title' => $title,
                            'body' => $message,
                            'deep_link' => route('admin.peminjaman.detail', $peminjaman->id),
                            'data' => [
                                'peminjaman_id' => $peminjaman->id,
                                'type' => 'admin_notification'
                            ]
                        ]
                    ]
                ]
            );

            return true;
        } catch (\Exception $e) {
            \Log::error('Admin notification error: ' . $e->getMessage());
            return false;
        }
    }
}