<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\Peminjaman;
use Pusher\PushNotifications\PushNotifications;

class NotificationService
{
    protected $beams;

    public function __construct()
    {
        $this->beams = new PushNotifications([
            'instanceId' => config('services.pusher.beams_instance_id'),
            'secretKey' => config('services.pusher.beams_secret_key'),
        ]);
    }

    public function sendToUser(int $userId, string $title, string $message, ?int $idPeminjaman = null): bool
    {
        try {
            \Log::info('Attempting to send notification to user: ' . $userId);
            \Log::info('Message: ' . $message);
            
            // Create notification record in database
            $notification = Notifikasi::create([
                'idPeminjaman' => $idPeminjaman,
                'judul' => $title,
                'isi' => $message,
                'isRead' => false
            ]);
            
            \Log::info('Notification created in database with ID: ' . $notification->id);

            // Send push notification to specific user using userId
            $response = $this->beams->publishToUsers(
                [strval($userId)],  // Convert userId to string as required by Pusher Beams
                [
                    "web" => [
                        "notification" => [
                            "title" => $title,
                            "body" => $message,
                        ]
                    ]
                ]
            );
            
            \Log::info('Pusher response: ' . json_encode($response));
            return true;
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return false;
        }
    }

    public function sendToAll(string $title, string $message): bool
    {
        try {
            // Create notification records for all users
            $users = \App\Models\User::all();
            foreach ($users as $user) {
                Notifikasi::create([
                    'idPeminjaman' => null,
                    'judul' => $title,
                    'isi' => $message,
                    'isRead' => false
                ]);
            }

            // Send broadcast to all users
            $response = $this->beams->publishToAll(
                [
                    "web" => [
                        "notification" => [
                            "title" => $title,
                            "body" => $message,
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
}