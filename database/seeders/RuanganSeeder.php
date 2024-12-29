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
                'nama' => 'Ruang A1.2',
                'gambar' => 'ruang-101.jpg',
                'deskripsi' => 'Ruang kuliah lantai 1',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, 40 kursi',
                'tarifunand' => 100000,
                'tarifumum' => 200000,
                'kelas' => 1,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 1,
                'nama' => 'Ruang A1.1',
                'gambar' => 'ruang-102.jpg',
                'deskripsi' => 'Ruang kuliah lantai 1',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, 40 kursi',
                'tarifunand' => 100000,
                'tarifumum' => 200000,
                'kelas' => 1,
                'status' => 'nonaktif'
            ],
            [
                'idSarana' => 1,
                'nama' => 'Ruang VIP',
                'gambar' => 'vip.jpg',
                'deskripsi' => 'Ruang kelas besar gedung A',
                'kapasitas' => 20,
                'fasilitas' => 'Proyektor, 70 kursi, Papan Tulis',
                'tarifunand' => 500000,
                'tarifumum' => 1000000,
                'kelas' => 1,
                'status' => 'aktif'
            ]
        ];

        foreach ($ruangan as $r) {
            Ruangan::create($r);
        }
    }
}