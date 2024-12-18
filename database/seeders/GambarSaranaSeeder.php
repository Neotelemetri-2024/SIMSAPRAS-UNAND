<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GambarSarana;

class GambarSaranaSeeder extends Seeder
{
    public function run()
    {
        $gambar = [
            [
                'idSarana' => 1,
                'gambar' => 'gedung-a-1.jpg'
            ],
            [
                'idSarana' => 1,
                'gambar' => 'gedung-a-2.jpg'
            ],
            [
                'idSarana' => 2,
                'gambar' => 'lapangan-1.jpg'
            ]
        ];

        foreach ($gambar as $g) {
            GambarSarana::create($g);
        }
    }
}
