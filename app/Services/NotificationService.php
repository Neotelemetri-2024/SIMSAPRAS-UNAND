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

    public function sendToUser(int $userId, string $title, string $message): bool
    {
        try {
            $this->beams->publishToUsers(
                [strval($userId)],
                [
                    "web" => [
                        "notification" => [
                            "title" => $title,
                            "body" => $message,
                            "urgent" => true,
                            "priority" => "high"
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

    public function sendToAll(string $title, string $message): bool
    {
        try {
            $this->beams->publishToInterests(
                ['peminjamanadmin'], // array of interests
                [
                    "web" => [
                        "notification" => [
                            "title" => $title,
                            "body" => $message,
                            "urgent" => true,
                            "priority" => "high"
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