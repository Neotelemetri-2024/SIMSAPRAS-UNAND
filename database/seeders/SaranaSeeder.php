<?php
// database/seeders/SaranaSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sarana;

class SaranaSeeder extends Seeder
{
    public function run()
    {
        $sarana = [
            [
                'IdKategori' => 1,
                'nama' => 'Gedung A',
                'gambar' => 'gedung-a.jpg',
                'deskripsi' => 'Gedung perkuliahan 4 lantai',
                'fasilitas' => 'AC, Proyektor, Wifi',
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 2,
                'nama' => 'Lapangan Sepakbola',
                'gambar' => 'lapangan.jpg',
                'deskripsi' => 'Lapangan sepakbola standar internasional',
                'fasilitas' => 'Rumput sintetis, Tribun, Lampu sorot',
                'status' => 'nonaktif'
            ],
            [
                'IdKategori' => 3,
                'nama' => 'Auditorium Utama',
                'gambar' => 'audi.jpg',
                'deskripsi' => 'Auditorium dengan kapasitas 1000 orang',
                'fasilitas' => 'Sound system, AC, Lighting',
                'status' => 'aktif'
            ]
        ];

        foreach ($sarana as $s) {
            Sarana::create($s);
        }
    }
}