<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TanggalPeminjaman;
use Carbon\Carbon;

class TanggalPeminjamanSeeder extends Seeder
{
    public function run()
    {
        $tanggal = [
            // Peminjaman 1 (diajukan - Ruangan)
            [
                'idPeminjaman' => 1,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->addWeeks(2)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 1,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(2)->format('Y-m-d')
            ],

            // Peminjaman 2 (diajukan - Sarana)
            [
                'idPeminjaman' => 2,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(3)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 2,
                'idJadwal' => 3,
                'tanggal' => Carbon::now()->addWeeks(3)->format('Y-m-d')
            ],

            // Peminjaman 3 (diproses - Ruangan)
            [
                'idPeminjaman' => 3,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->addWeeks(2)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 3,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(2)->format('Y-m-d')
            ],

            // Peminjaman 4 (diproses - Sarana)
            [
                'idPeminjaman' => 4,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->addWeeks(4)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 4,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(4)->addDays(1)->format('Y-m-d')
            ],

            // Peminjaman 5 (disetujui - Ruangan)
            [
                'idPeminjaman' => 5,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->addWeeks(1)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 5,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(1)->format('Y-m-d')
            ],

            // Peminjaman 6 (disetujui - Sarana)
            [
                'idPeminjaman' => 6,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->addWeeks(2)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 6,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(2)->addDays(1)->format('Y-m-d')
            ],

            // Peminjaman 7 (ditolak - Ruangan)
            [
                'idPeminjaman' => 7,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(3)->format('Y-m-d')
            ],

            // Peminjaman 8 (ditolak - Sarana)
            [
                'idPeminjaman' => 8,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(2)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 8,
                'idJadwal' => 3,
                'tanggal' => Carbon::now()->addWeeks(2)->format('Y-m-d')
            ],

            // Peminjaman 9 (dibatalkan - Ruangan)
            [
                'idPeminjaman' => 9,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->addWeeks(4)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 9,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(4)->format('Y-m-d')
            ],

            // Peminjaman 10 (dibatalkan - Sarana)
            [
                'idPeminjaman' => 10,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->addMonth()->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 10,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addMonth()->format('Y-m-d')
            ],

            // Peminjaman 11 (diajukanbatal - Ruangan)
            [
                'idPeminjaman' => 11,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->addWeeks(2)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 11,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(2)->format('Y-m-d')
            ],

            // Peminjaman 12 (diajukanbatal - Sarana)
            [
                'idPeminjaman' => 12,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->addWeeks(3)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 12,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->addWeeks(3)->addDays(1)->format('Y-m-d')
            ],

            // Peminjaman 13 (selesai - Ruangan)
            [
                'idPeminjaman' => 13,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->subWeeks(1)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 13,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->subWeeks(1)->format('Y-m-d')
            ],

            // Peminjaman 14 (selesai - Sarana)
            [
                'idPeminjaman' => 14,
                'idJadwal' => 1,
                'tanggal' => Carbon::now()->subWeeks(2)->format('Y-m-d')
            ],
            [
                'idPeminjaman' => 14,
                'idJadwal' => 2,
                'tanggal' => Carbon::now()->subWeeks(2)->addDays(1)->format('Y-m-d')
            ],
        ];

        foreach ($tanggal as $t) {
            TanggalPeminjaman::create($t);
        }
    }
}