<?php
// database/seeders/PengumumanSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengumuman;

class PengumumanSeeder extends Seeder
{
    public function run()
    {
        $pengumuman = [
            [
                'judul' => 'Pemeliharaan Sistem',
                'isi' => 'Sistem akan mengalami pemeliharaan pada tanggal 20 December 2024',
                'penulis' => 2
            ],
            [
                'judul' => 'Perubahan Jadwal',
                'isi' => 'Mulai January 2025, jadwal peminjaman akan disesuaikan dengan kalender akademik baru',
                'penulis' => 2
            ]
        ];

        foreach ($pengumuman as $p) {
            Pengumuman::create($p);
        }
    }
}