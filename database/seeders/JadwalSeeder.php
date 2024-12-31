<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        $jadwal = [
            [
                'shift' => 'Pagi',
                'mulai' => '08:00:00',
                'selesai' => '12:00:00',
                'status' => 'aktif'
            ],
            [
                'shift' => 'Siang',
                'mulai' => '13:00:00',
                'selesai' => '17:00:00',
                'status' => 'aktif'
            ],
            [
                'shift' => 'Malam',
                'mulai' => '18:00:00',
                'selesai' => '22:00:00',
                'status' => 'aktif'
            ]
        ];

        foreach ($jadwal as $j) {
            Jadwal::create($j);
        }
    }
}