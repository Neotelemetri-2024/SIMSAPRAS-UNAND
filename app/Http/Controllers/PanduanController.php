<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanduanController extends Controller
{
    public function index()
    {
        return view('panduan');
    }

    public function status()
    {
        $statuses = [
            [
                'status' => 'Diajukan',
                'description' => 'Peminjaman telah diajukan dan menunggu peninjauan admin.',
                'color' => 'blue',
                'icon' => 'M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75'
            ],
            [
                'status' => 'Diproses',
                'description' => 'Admin sedang memproses pengajuan peminjaman.',
                'color' => 'yellow',
                'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            [
                'status' => 'Disetujui',
                'description' => 'Peminjaman telah disetujui dan dapat digunakan.',
                'color' => 'green',
                'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            [
                'status' => 'Ditolak',
                'description' => 'Peminjaman ditolak oleh admin.',
                'color' => 'orange',
                'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            [
                'status' => 'Dibatalkan',
                'description' => 'Peminjaman dibatalkan oleh peminjam.',
                'color' => 'red',
                'icon' => 'M6 18L18 6M6 6l12 12'
            ],
            [
                'status' => 'Diajukan Batal',
                'description' => 'Pengajuan pembatalan peminjaman sedang diproses.',
                'color' => 'purple',
                'icon' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z'
            ],
        ];

        return view('status', compact('statuses'));
    }

    public function syarat()
    {
        $requirements = [
            [
                'title' => 'Persyaratan Umum',
                'items' => [
                    'Merupakan civitas akademika Universitas Andalas',
                    'Melakukan pendaftaran akun SIMSAPRAS dengan menggunakan identitas yang sesuai dan terverifikasi',
                    'Mengisi formulir peminjaman dengan lengkap dan benar',
                    'Bersedia mematuhi semua peraturan yang berlaku'
                ]
            ],
            [
                'title' => 'Dokumen yang Diperlukan',
                'items' => [
                    'Surat permohonan peminjaman resmi dari instansi',
                    'Rundown acara (untuk peminjaman ruangan)',
                    'Formulir yang diisi langsung melalui website SIMSAPRAS',
                    'Surat rekomendasi dari fakultas/jurusan (jika diperlukan)'
                ]
            ],
            [
                'title' => 'Ketentuan Peminjaman',
                'items' => [
                    'Peminjaman harus diajukan minimal 7 hari sebelum penggunaan',
                    'Peminjaman Ruangan Kelas hanya dapat dilakukan pada hari Sabtu dan Minggu',
                    'Peminjaman yang dilakukan melewati pukul 16:00 (4 sore) akan dikenakan tarif tambahan',
                    'Peminjaman di hari Sabtu atau Minggu akan dikenakan tarif tambahan',
                    'Peminjam bertanggung jawab atas kondisi sarana yang dipinjam',
                    'Kerusakan atau kehilangan menjadi tanggung jawab peminjam'
                ]
            ],
            [
                'title' => 'Pembatalan dan Perubahan',
                'items' => [
                    'Pembatalan harus dilakukan minimal 3 hari sebelum jadwal penggunaan',
                    'Pembatalan mendadak dapat mempengaruhi pengajuan peminjaman selanjutnya',
                    'Perubahan data peminjaman harus mendapat persetujuan admin',
                    'Peminjaman yang telah disetujui dapat sewaktu-waktu dibatalkan jika terdapat agenda mendesak dari pihak Universitas Andalas',
                    'Peminjaman yang dibatalkan dari pihak Universitas Andalas akan mendapatkan refund penuh',
                ]
            ]
        ];

        return view('syarat', compact('requirements'));
    }

    public function cara () {
        return view('cara');
    }
}