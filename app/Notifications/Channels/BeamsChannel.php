<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Pusher\PushNotifications\PushNotifications;

class BeamsChannel
{
    protected $beams;

    public function __construct(PushNotifications $beams)
    {
        $this->beams = $beams;
    }

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toBeams')) {
            throw new \Exception('Notification class must implement toBeams method');
        }

        $payload = $notification->toBeams($notifiable);
        
        // Untuk user, gunakan publishToUsers
        return $this->beams->publishToUsers(
            [(string)$notifiable->id],
            $payload
        );
    }
}