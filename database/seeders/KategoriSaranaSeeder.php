<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriSarana;

class KategoriSaranaSeeder extends Seeder
{
    public function run()
    {
        $kategori = [
            [
                'jenis' => 'Gedung Beruangan',
                'deskripsi' => 'Sarana berupa gedung untuk berbagai kegiatan'
            ],
            [
                'jenis' => 'Gedung Tunggal',
                'deskripsi' => 'Sarana berupa gedung untuk berbagai kegiatan'
            ],
            [
                'jenis' => 'Lapangan',
                'deskripsi' => 'Sarana olahraga outdoor'
            ],
        ];

        foreach ($kategori as $k) {
            KategoriSarana::create($k);
        }
    }
}