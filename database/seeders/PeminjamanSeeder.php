<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        $peminjaman = [
            [
                'idUser' => 5,
                'idRuangan' => null,
                'idSarana' => 3, 
                'kegiatan' => 'Workshop Microsoft',
                'suratPeminjaman' => 'surat-1.pdf',
                'rundown' => 'rundown-1.pdf',
                'instansi' => 'Fakultas Teknologi Informasi',
                'estimasiPeserta' => 30,
                'totalTarif' => 0,
                'isUnand' => true,
                'status' => 'diajukan',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum'
            ],
            [
                'idUser' => 5,
                'idRuangan' => 1,
                'idSarana' => 1, 
                'kegiatan' => 'Seminar Tugas Akhir',
                'suratPeminjaman' => 'surat-1.pdf',
                'rundown' => 'rundown-1.pdf',
                'instansi' => 'Fakultas Teknik',
                'estimasiPeserta' => 30,
                'totalTarif' => 100000,
                'isUnand' => true,
                'status' => 'diajukan',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum'
            ],
            // Status: diajukan (Sarana tanpa Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => null,
                'idSarana' => 2, // Lapangan Sepakbola
                'kegiatan' => 'Turnamen Futsal Fakultas',
                'suratPeminjaman' => 'surat-2.pdf',
                'rundown' => 'rundown-2.pdf',
                'instansi' => 'UKM Olahraga',
                'estimasiPeserta' => 100,
                'totalTarif' => 500000,
                'isUnand' => true,
                'status' => 'diajukan',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum'
            ],

            // Status: diproses (Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => 3,
                'idSarana' => 1, 
                'kegiatan' => 'Workshop Robotika',
                'suratPeminjaman' => 'surat-3.pdf',
                'rundown' => 'rundown-3.pdf',
                'instansi' => 'UKM Robotika',
                'estimasiPeserta' => 40,
                'totalTarif' => 500000,
                'isUnand' => true,
                'status' => 'diproses',
                'diproses_oleh' => 1,
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'diproses_at' => Carbon::now()->subDays(1)
            ],
            // Status: diproses (Sarana tanpa Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => null,
                'idSarana' => 3, // Auditorium Utama
                'kegiatan' => 'Wisuda Periode II',
                'suratPeminjaman' => 'surat-4.pdf',
                'rundown' => 'rundown-4.pdf',
                'instansi' => 'Fakultas MIPA',
                'estimasiPeserta' => 500,
                'totalTarif' => 2000000,
                'isUnand' => true,
                'status' => 'diproses',
                'diproses_oleh' => 1,
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'diproses_at' => Carbon::now()->subDays(1)
            ],

            // Status: disetujui (Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => 1,
                'idSarana' => 1, 
                'kegiatan' => 'Rapat Kerja Fakultas',
                'suratPeminjaman' => 'surat-5.pdf',
                'rundown' => 'rundown-5.pdf',
                'instansi' => 'Fakultas Teknik',
                'estimasiPeserta' => 30,
                'totalTarif' => 100000,
                'isUnand' => true,
                'status' => 'disetujui',
                'disetujui_oleh' => 1,
                'diproses_oleh' => 1,
                'statusPembayaran' => 'lunas',
                'statusPengembalian' => 'belum',
                'buktiPembayaran' => 'bukti-5.pdf',
                'disetujui_at' => Carbon::now(),
                'diproses_at' => Carbon::now()->subDays(1)
            ],
            // Status: disetujui (Sarana tanpa Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => null,
                'idSarana' => 3, // Auditorium Utama
                'kegiatan' => 'Kuliah Umum',
                'suratPeminjaman' => 'surat-6.pdf',
                'rundown' => 'rundown-6.pdf',
                'instansi' => 'Fakultas Teknik',
                'estimasiPeserta' => 200,
                'totalTarif' => 1000000,
                'isUnand' => true,
                'status' => 'disetujui',
                'disetujui_oleh' => 1,
                'diproses_oleh' => 1,
                'statusPembayaran' => 'lunas',
                'statusPengembalian' => 'belum',
                'buktiPembayaran' => 'bukti-6.pdf',
                'disetujui_at' => Carbon::now(),
                'diproses_at' => Carbon::now()->subDays(1)
            ],

            // Status: ditolak (Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => 2,
                'idSarana' => 1, 
                'kegiatan' => 'Seminar Nasional',
                'suratPeminjaman' => 'surat-7.pdf',
                'rundown' => 'rundown-7.pdf',
                'instansi' => 'Himpunan Mahasiswa',
                'estimasiPeserta' => 50,
                'totalTarif' => 100000,
                'isUnand' => true,
                'status' => 'ditolak',
                'ditolak_oleh' => 1,
                'feedbackPenolakan' => 'Jadwal bentrok dengan kegiatan fakultas',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'ditolak_at' => Carbon::now()->subDays(2)
            ],
            // Status: ditolak (Sarana tanpa Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => null,
                'idSarana' => 2, // Lapangan Sepakbola
                'kegiatan' => 'Pertandingan Futsal',
                'suratPeminjaman' => 'surat-8.pdf',
                'rundown' => 'rundown-8.pdf',
                'instansi' => 'UKM Futsal',
                'estimasiPeserta' => 100,
                'totalTarif' => 500000,
                'isUnand' => true,
                'status' => 'ditolak',
                'ditolak_oleh' => 1,
                'feedbackPenolakan' => 'Lapangan dalam perbaikan',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'ditolak_at' => Carbon::now()->subDays(2)
            ],

            // Status: dibatalkan (Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => 1,
                'idSarana' => 1, 
                'kegiatan' => 'Workshop Programming',
                'suratPeminjaman' => 'surat-9.pdf',
                'rundown' => 'rundown-9.pdf',
                'instansi' => 'Himpunan Mahasiswa',
                'estimasiPeserta' => 40,
                'totalTarif' => 100000,
                'isUnand' => true,
                'status' => 'dibatalkan',
                'dibatalkan_oleh' => 3,
                'statusSebelumBatal' => 'disetujui',
                'alasanPembatalan' => 'Perubahan jadwal kegiatan',
                'feedbackPembatalan' => 'Pembatalan disetujui',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'dibatalkan_at' => Carbon::now()->subDays(3)
            ],
            // Status: dibatalkan (Sarana tanpa Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => null,
                'idSarana' => 3, // Auditorium Utama
                'kegiatan' => 'Seminar Internasional',
                'suratPeminjaman' => 'surat-10.pdf',
                'rundown' => 'rundown-10.pdf',
                'instansi' => 'Fakultas Teknik',
                'estimasiPeserta' => 300,
                'totalTarif' => 2000000,
                'isUnand' => true,
                'status' => 'dibatalkan',
                'dibatalkan_oleh' => 2,
                'statusSebelumBatal' => 'disetujui',
                'alasanPembatalan' => 'Pembicara berhalangan hadir',
                'feedbackPembatalan' => 'Pembatalan disetujui',
                'statusPembayaran' => 'tidak',
                'statusPengembalian' => 'belum',
                'dibatalkan_at' => Carbon::now()->subDays(3)
            ],

            // Status: diajukanbatal (Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => 3,
                'idSarana' => 1, 
                'kegiatan' => 'Pelatihan Komputer',
                'suratPeminjaman' => 'surat-11.pdf',
                'rundown' => 'rundown-11.pdf',
                'instansi' => 'Lab Komputer',
                'estimasiPeserta' => 20,
                'totalTarif' => 500000,
                'isUnand' => true,
                'status' => 'diajukanbatal',
                'statusSebelumBatal' => 'disetujui',
                'alasanPembatalan' => 'Jumlah peserta tidak memenuhi kuota',
                'statusPembayaran' => 'lunas',
                'statusPengembalian' => 'belum'
            ],
            // Status: diajukanbatal (Sarana tanpa Ruangan)
            [
                'idUser' => 4,
                'idRuangan' => null,
                'idSarana' => 3, // Auditorium Utama
                'kegiatan' => 'Dies Natalis Fakultas',
                'suratPeminjaman' => 'surat-12.pdf',
                'rundown' => 'rundown-12.pdf',
                'instansi' => 'Fakultas MIPA',
                'estimasiPeserta' => 400,
                'totalTarif' => 1000000,
                'isUnand' => true,
                'status' => 'diajukanbatal',
                'statusSebelumBatal' => 'disetujui',
                'alasanPembatalan' => 'Perubahan venue kegiatan',
                'statusPembayaran' => 'lunas',
                'statusPengembalian' => 'belum'
            ],

            // Status: selesai (Ruangan)
            [
                'idUser' => 5,
                'idRuangan' => 1,
                'idSarana' => 1, 
                'kegiatan' => 'Ujian Akhir Semester',
                'suratPeminjaman' => 'surat-13.pdf',
                'rundown' => 'rundown-13.pdf',
                'instansi' => 'Fakultas Teknik',
                'estimasiPeserta' => 40,
                'totalTarif' => 100000,
                'isUnand' => true,
                'status' => 'selesai',
                'disetujui_oleh' => 1,
                'diproses_oleh' => 1,
                'statusPembayaran' => 'lunas',
                'statusPengembalian' => 'sudah',
                'buktiPembayaran' => 'bukti-13.pdf',
                'evaluasi' => 'Kegiatan berjalan lancar',
                'disetujui_at' => Carbon::now()->subWeek(),
                'diproses_at' => Carbon::now()->subWeek()->addDays(1)
            ],
            // Status: selesai (Sarana tanpa Ruangan)
            [
               'idUser' => 5,
                'idRuangan' => 1,
                'idSarana' => 1, 
                'kegiatan' => 'Wisuda Periode I',
                'suratPeminjaman' => 'surat-14.pdf',
                'rundown' => 'rundown-14.pdf',
                'instansi' => 'Universitas',
                'estimasiPeserta' => 1000,
                'totalTarif' => 2000000,
                'isUnand' => true,
                'status' => 'selesai',
                'disetujui_oleh' => 1,
                'diproses_oleh' => 1,
                'statusPembayaran' => 'lunas',
                'statusPengembalian' => 'sudah',
                'buktiPembayaran' => 'bukti-14.pdf',
                'evaluasi' => 'Acara sukses, fasilitas memadai',
                'disetujui_at' => Carbon::now()->subWeek(),
            ]
        ];

        foreach ($peminjaman as $p) {
            Peminjaman::create($p);
        }
    }
}