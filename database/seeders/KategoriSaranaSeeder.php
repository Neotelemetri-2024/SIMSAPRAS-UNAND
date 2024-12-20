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
                'deskripsi' => 'Sarana berupa gedung untuk berbagai kegiatan',
                'status' => 'aktif'
            ],
            [
                'jenis' => 'Gedung Tunggal',
                'deskripsi' => 'Sarana berupa gedung untuk berbagai kegiatan',
                'status' => 'nonaktif'
            ],
            [
                'jenis' => 'Lapangan',
                'deskripsi' => 'Sarana olahraga outdoor',
                'status' => 'aktif'
            ],
            [
                'jenis' => 'Perpustakaan',
                'deskripsi' => 'Sarana berupa gedung untuk berbagai kegiatan',
                'status' => 'aktif'
            ],
            [
                'jenis' => 'Laboratorium',
                'deskripsi' => 'Sarana berupa gedung untuk berbagai kegiatan',
                'status' => 'nonaktif'
            ],
        ];

        foreach ($kategori as $k) {
            KategoriSarana::create($k);
        }
    }
}