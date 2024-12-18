<?php
// database/seeders/TanggalPeminjamanSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TanggalPeminjaman;
use Carbon\Carbon;

class TanggalPeminjamanSeeder extends Seeder
{
    public function run()
    {
        // Contoh: setiap peminjaman memiliki 3 tanggal
        $tanggal = [
            [
                'idPeminjaman' => 1,
                'tanggal' => Carbon::now()->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 1,
                'tanggal' => Carbon::now()->addDays(1)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 1,
                'tanggal' => Carbon::now()->addDays(2)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 2,
                'tanggal' => Carbon::now()->addDays(7)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 2,
                'tanggal' => Carbon::now()->addDays(8)->format('Y-m-d')
            ]
        ];

        foreach ($tanggal as $t) {
            TanggalPeminjaman::create($t);
        }
    }
}