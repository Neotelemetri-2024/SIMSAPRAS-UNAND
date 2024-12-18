<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GambarRuangan;

class GambarRuanganSeeder extends Seeder
{
    public function run()
    {
        $gambar = [
            [
                'idRuangan' => 1,
                'gambar' => 'ruang-101-1.jpg'
            ],
            [
                'idRuangan' => 1,
                'gambar' => 'ruang-101-2.jpg'
            ],
            [
                'idRuangan' => 2,
                'gambar' => 'ruang-102-1.jpg'
            ]
        ];

        foreach ($gambar as $g) {
            GambarRuangan::create($g);
        }
    }
}