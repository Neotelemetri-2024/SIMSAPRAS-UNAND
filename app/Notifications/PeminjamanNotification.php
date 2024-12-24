<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Peminjaman;
use App\Models\Notifikasi;
use App\Notifications\Channels\BeamsChannel;

class PeminjamanNotification extends Notification
{
    protected $peminjaman;
    protected $title;
    protected $message;
    protected $type;

    public function __construct(Peminjaman $peminjaman, $title, $message, $type = 'user')
    {
        $this->peminjaman = $peminjaman;
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return [BeamsChannel::class];
    }

    public function toBeams($notifiable)
    {
        // Simpan ke tabel notifikasi custom
        Notifikasi::create([
            'idPeminjaman' => $this->peminjaman->id,
            'judul' => $this->title,
            'isi' => $this->message,
            'isRead' => false
        ]);

        return [
            'web' => [
                'notification' => [
                    'title' => $this->title,
                    'body' => $this->message,
                    'deep_link' => url('/peminjaman/' . $this->peminjaman->id),
                    'data' => [
                        'peminjaman_id' => $this->peminjaman->id,
                        'type' => $this->type,
                        'status' => $this->peminjaman->status
                    ]
                ],
            ],
        ];
    }
}