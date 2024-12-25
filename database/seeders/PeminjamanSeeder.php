<?php
// database/seeders/PeminjamanSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        $peminjaman = [
            [
                'idUser' => 4,
                'idRuangan' => 1,
                'idSarana' => 1,
                'kegiatan' => 'Seminar Tugas Akhir',
                'suratPeminjaman' => 'surat-1.pdf',
                'rundown' => 'rundown-1.pdf',
                'instansi' => 'Fakultas Teknik',
                'estimasiPeserta' => 30,
                'tarif' => 0,
                'status' => 'disetujui'
            ],
            [
                'idUser' => 4,
                'idRuangan' => 2,
                'idSarana' => 1,
                'kegiatan' => 'Rapat Himpunan',
                'suratPeminjaman' => 'surat-2.pdf',
                'rundown' => 'rundown-2.pdf',
                'instansi' => 'Himpunan Mahasiswa',
                'estimasiPeserta' => 25,
                'tarif' => 0,
                'status' => 'diajukan'
            ]
        ];

        foreach ($peminjaman as $p) {
            Peminjaman::create($p);
        }
    }
}