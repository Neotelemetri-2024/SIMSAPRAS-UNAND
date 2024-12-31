<?php
// database/seeders/PeminjamanSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\TanggalPeminjaman;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        $peminjaman = [
            // Status: Diajukan
            [
                'idUser' => 4,
                'idRuangan' => 1, // Ruang A1.2
                'idSarana' => 1,  // Gedung A
                'kegiatan' => 'Seminar Tugas Akhir',
                'suratPeminjaman' => 'surat-1.pdf',
                'rundown' => 'rundown-1.pdf',
                'instansi' => 'Fakultas Teknik',
                'estimasiPeserta' => 30,
                'totalTarif' => 100000,
                'isUnand' => true,
                'status' => 'diajukan',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'tanggalPeminjaman' => [
                    ['idJadwal' => 1, 'tanggal' => Carbon::now()->format('Y-m-d')],
                    ['idJadwal' => 2, 'tanggal' => Carbon::now()->addDays(1)->format('Y-m-d')],
                    ['idJadwal' => 2, 'tanggal' => Carbon::now()->addDays(2)->format('Y-m-d')]
                ]
            ],
            [
                'idUser' => 4,
                'idRuangan' => 3, // Ruang VIP
                'idSarana' => 1,  // Gedung A
                'kegiatan' => 'Workshop Robotika',
                'suratPeminjaman' => 'surat-2.pdf',
                'rundown' => 'rundown-2.pdf',
                'instansi' => 'UKM Robotika',
                'estimasiPeserta' => 20,
                'totalTarif' => 500000,
                'isUnand' => true,
                'status' => 'diajukan',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'tanggalPeminjaman' => [
                    ['idJadwal' => 3, 'tanggal' => Carbon::now()->addDays(7)->format('Y-m-d')],
                    ['idJadwal' => 3, 'tanggal' => Carbon::now()->addDays(8)->format('Y-m-d')]
                ]
            ],

            // Status: Ditolak
            [
                'idUser' => 4,
                'idRuangan' => 1,
                'idSarana' => 1,
                'kegiatan' => 'Pelatihan Komputer',
                'suratPeminjaman' => 'surat-3.pdf',
                'rundown' => 'rundown-3.pdf',
                'instansi' => 'Himpunan Mahasiswa',
                'estimasiPeserta' => 40,
                'totalTarif' => 100000,
                'isUnand' => true,
                'status' => 'ditolak',
                'ditolak_oleh' => 1,
                'ditolak_at' => Carbon::now(),
                'feedbackPenolakan' => 'Ruangan sudah dibooking untuk kegiatan lain',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'tanggalPeminjaman' => [
                    ['idJadwal' => 1, 'tanggal' => Carbon::now()->addDays(14)->format('Y-m-d')],
                    ['idJadwal' => 2, 'tanggal' => Carbon::now()->addDays(14)->format('Y-m-d')]
                ]
            ],

            // Status: Diproses
            [
                'idUser' => 4,
                'idRuangan' => 1,
                'idSarana' => 1,
                'kegiatan' => 'Seminar Nasional',
                'suratPeminjaman' => 'surat-4.pdf',
                'rundown' => 'rundown-4.pdf',
                'instansi' => 'Fakultas MIPA',
                'estimasiPeserta' => 35,
                'totalTarif' => 100000,
                'isUnand' => true,
                'status' => 'diproses',
                'diproses_oleh' => 1,
                'diproses_at' => Carbon::now(),
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'tanggalPeminjaman' => [
                    ['idJadwal' => 2, 'tanggal' => Carbon::now()->addDays(21)->format('Y-m-d')]
                ]
            ],

            // Status: Disetujui
            [
                'idUser' => 4,
                'idRuangan' => 3,
                'idSarana' => 3,
                'kegiatan' => 'Wisuda',
                'suratPeminjaman' => 'surat-5.pdf',
                'rundown' => 'rundown-5.pdf',
                'instansi' => 'Rektorat',
                'estimasiPeserta' => 20,
                'totalTarif' => 2000000,
                'isUnand' => true,
                'status' => 'disetujui',
                'disetujui_oleh' => 1,
                'disetujui_at' => Carbon::now(),
                'statusPembayaran' => 'lunas',
                'buktiPembayaran' => 'bukti-5.pdf',
                'statusPengembalian' => 'belum',
                'tanggalPeminjaman' => [
                    ['idJadwal' => 1, 'tanggal' => Carbon::now()->addDays(30)->format('Y-m-d')],
                    ['idJadwal' => 2, 'tanggal' => Carbon::now()->addDays(30)->format('Y-m-d')],
                    ['idJadwal' => 3, 'tanggal' => Carbon::now()->addDays(30)->format('Y-m-d')]
                ]
            ],

            // Status: Dibatalkan
            [
                'idUser' => 4,
                'idRuangan' => 1,
                'idSarana' => 1,
                'kegiatan' => 'Seminar Motivasi',
                'suratPeminjaman' => 'surat-6.pdf',
                'rundown' => 'rundown-6.pdf',
                'instansi' => 'BEM Universitas',
                'estimasiPeserta' => 35,
                'totalTarif' => 100000,
                'isUnand' => true,
                'status' => 'dibatalkan',
                'dibatalkan_oleh' => 1,
                'dibatalkan_at' => Carbon::now(),
                'alasanPembatalan' => 'Jadwal bertabrakan dengan kegiatan lain',
                'statusSebelumBatal' => 'disetujui',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'tanggalPeminjaman' => [
                    ['idJadwal' => 1, 'tanggal' => Carbon::now()->addDays(45)->format('Y-m-d')]
                ]
            ]
        ];

        foreach ($peminjaman as $p) {
            $tanggalPeminjaman = $p['tanggalPeminjaman'];
            unset($p['tanggalPeminjaman']);
            
            $peminjamanModel = Peminjaman::create($p);
            
            // Create TanggalPeminjaman records
            foreach ($tanggalPeminjaman as $t) {
                TanggalPeminjaman::create([
                    'idPeminjaman' => $peminjamanModel->id,
                    'idJadwal' => $t['idJadwal'],
                    'tanggal' => $t['tanggal']
                ]);
            }
        }
    }
}