<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notifikasi;

class NotifikasiSeeder extends Seeder
{
    public function run()
    {
        $notifikasi = [
            [
                'idPeminjaman' => 1,
                'judul' => 'Peminjaman Disetujui',
                'isi' => 'Peminjaman ruangan untuk Seminar Tugas Akhir telah disetujui',
                'isRead' => false
            ],
            [
                'idPeminjaman' => 2,
                'judul' => 'Peminjaman Diajukan',
                'isi' => 'Peminjaman ruangan untuk Rapat Himpunan telah diajukan dan menunggu persetujuan',
                'isRead' => false
            ]
        ];

        foreach ($notifikasi as $n) {
            Notifikasi::create($n);
        }
    }
}