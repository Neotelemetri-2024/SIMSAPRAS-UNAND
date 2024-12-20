<?php
// database/seeders/RuanganSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    public function run()
    {
        $ruangan = [
            [
                'idSarana' => 1,
                'nama' => 'Ruang 101',
                'gambar' => 'ruang-101.jpg',
                'deskripsi' => 'Ruang kuliah lantai 1',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, 40 kursi',
                'status' => 'aktif'
            ],
            [
                'idSarana' => 2,
                'nama' => 'Ruang 102',
                'gambar' => 'ruang-102.jpg',
                'deskripsi' => 'Ruang kuliah lantai 1',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, 40 kursi',
                'status' => 'nonaktif'
            ],
            [
                'idSarana' => 3,
                'nama' => 'Ruang VIP',
                'gambar' => 'vip.jpg',
                'deskripsi' => 'Ruang VIP Auditorium',
                'kapasitas' => 20,
                'fasilitas' => 'AC, Sofa, TV',
                'status' => 'aktif'
            ]
        ];

        foreach ($ruangan as $r) {
            Ruangan::create($r);
        }
    }
}