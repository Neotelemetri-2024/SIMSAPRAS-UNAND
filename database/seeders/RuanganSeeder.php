<?php

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
                'nama' => 'A 1.7',
                'gambar' => 'a-1-7.jpg',
                'deskripsi' => 'Ruang kelas di Gedung A',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 1,
                'nama' => 'A 1.8',
                'gambar' => 'a-1-8.jpg',
                'deskripsi' => 'Ruang kelas di Gedung A',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 2,
                'nama' => 'C 1.13',
                'gambar' => 'c-1-13.jpg',
                'deskripsi' => 'Ruang kelas di Gedung C',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 2,
                'nama' => 'C 1.14',
                'gambar' => 'c-1-14.jpg',
                'deskripsi' => 'Ruang kelas di Gedung C',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 3,
                'nama' => 'D 2.7',
                'gambar' => 'd-2-7.jpg',
                'deskripsi' => 'Ruang kelas di Gedung D',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 4,
                'nama' => 'E 1.2',
                'gambar' => 'e-1-2.jpg',
                'deskripsi' => 'Ruang kelas di Gedung E',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 4,
                'nama' => 'E 1.1',
                'gambar' => 'e-1-1.jpg',
                'deskripsi' => 'Ruang kelas di Gedung E',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 4,
                'nama' => 'Seminar E',
                'gambar' => 'seminar-e.jpg',
                'deskripsi' => 'Ruang seminar di Gedung E',
                'kapasitas' => 100,
                'fasilitas' => 'AC, Proyektor, Sound System, Kursi',
                'tariformawa' => 150000,
                'tarifunit' => 200000,
                'tarifumum' => 250000,
                'kelas' => false,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 5,
                'nama' => 'F 1.5',
                'gambar' => 'f-1-5.jpg',
                'deskripsi' => 'Ruang kelas di Gedung F',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 5,
                'nama' => 'F 1.6',
                'gambar' => 'f-1-6.jpg',
                'deskripsi' => 'Ruang kelas di Gedung F',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 5,
                'nama' => 'F 1.14',
                'gambar' => 'f-1-14.jpg',
                'deskripsi' => 'Ruang kelas di Gedung F',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 5,
                'nama' => 'F 2.5',
                'gambar' => 'f-2-5.jpg',
                'deskripsi' => 'Ruang kelas di Gedung F',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 5,
                'nama' => 'Seminar F',
                'gambar' => 'seminar-f.jpg',
                'deskripsi' => 'Ruang seminar di Gedung F',
                'kapasitas' => 100,
                'fasilitas' => 'AC, Proyektor, Sound System, Kursi',
                'tariformawa' => 150000,
                'tarifunit' => 200000,
                'tarifumum' => 250000,
                'kelas' => false,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 6,
                'nama' => 'G 1.8',
                'gambar' => 'g-1-8.jpg',
                'deskripsi' => 'Ruang kelas di Gedung G',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Papan Tulis, Kursi',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'kelas' => true,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 7,
                'nama' => 'Seminar I',
                'gambar' => 'seminar-i.jpg',
                'deskripsi' => 'Ruang seminar di Gedung I',
                'kapasitas' => 100,
                'fasilitas' => 'AC, Proyektor, Sound System, Kursi',
                'tariformawa' => 150000,
                'tarifunit' => 200000,
                'tarifumum' => 250000,
                'kelas' => false,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 8,
                'nama' => 'Ruang Rapat Rektorat',
                'gambar' => 'ruang-rapat.jpg',
                'deskripsi' => 'Ruangan rapat di dalam gedung Rektorat',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor, Sound System, Meja Rapat',
                'tariformawa' => 0,
                'tarifunit' => 100000,
                'tarifumum' => 0,
                'kelas' => false,
                'status' => 'aktif'
            ],
            [
                'idSarana' => 9,
                'nama' => 'Pustaka lat. 5',
                'gambar' => 'pustaka-5.jpg',
                'deskripsi' => 'Ruang baca di Perpustakaan',
                'kapasitas' => 50,
                'fasilitas' => 'AC, Meja Baca, Kursi, WiFi',
                'tariformawa' => 0,
                'tarifunit' => 0,
                'tarifumum' => 0,
                'kelas' => false,
                'status' => 'aktif'
            ],
        ];

        foreach ($ruangan as $r) {
            Ruangan::create($r);
        }
    }
}