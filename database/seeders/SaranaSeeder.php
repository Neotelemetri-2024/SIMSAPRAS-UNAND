<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sarana;

class SaranaSeeder extends Seeder
{
    public function run()
    {
        $sarana = [
            // Gedung Beruangan
            [
                'IdKategori' => 1, // Gedung Beruangan
                'nama' => 'Gedung A',
                'gambar' => 'gedung-a.jpg',
                'deskripsi' => 'Gedung perkuliahan dengan fasilitas modern',
                'kapasitas' => 500,
                'fasilitas' => 'Toilet, Mushola',
                'tariformawa' => 100000,
                'tarifunit' => 150000,
                'tarifumum' => 200000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 1,
                'nama' => 'Gedung C',
                'gambar' => 'gedung-c.jpg',
                'deskripsi' => 'Gedung perkuliahan dengan area yang luas',
                'kapasitas' => 500,
                'fasilitas' => 'Toilet, Mushola',
                'tariformawa' => 100000,
                'tarifunit' => 150000,
                'tarifumum' => 200000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 1,
                'nama' => 'Gedung D',
                'gambar' => 'gedung-d.jpg',
                'deskripsi' => 'Gedung perkuliahan dengan fasilitas lengkap',
                'kapasitas' => 500,
                'fasilitas' => 'Toilet, Mushola',
                'tariformawa' => 100000,
                'tarifunit' => 150000,
                'tarifumum' => 200000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 1,
                'nama' => 'Gedung E',
                'gambar' => 'gedung-e.jpg',
                'deskripsi' => 'Gedung perkuliahan dan ruang seminar',
                'kapasitas' => 500,
                'fasilitas' => 'Toilet, Mushola',
                'tariformawa' => 100000,
                'tarifunit' => 150000,
                'tarifumum' => 200000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 1,
                'nama' => 'Gedung F',
                'gambar' => 'gedung-f.jpg',
                'deskripsi' => 'Gedung perkuliahan dan ruang seminar',
                'kapasitas' => 500,
                'fasilitas' => 'Toilet, Mushola',
                'tariformawa' => 100000,
                'tarifunit' => 150000,
                'tarifumum' => 200000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 1,
                'nama' => 'Gedung G',
                'gambar' => 'gedung-g.jpg',
                'deskripsi' => 'Gedung perkuliahan modern',
                'kapasitas' => 500,
                'fasilitas' => 'Toilet, Mushola',
                'tariformawa' => 100000,
                'tarifunit' => 150000,
                'tarifumum' => 200000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 1,
                'nama' => 'Gedung I',
                'gambar' => 'gedung-i.jpg',
                'deskripsi' => 'Gedung dengan ruang seminar',
                'kapasitas' => 500,
                'fasilitas' => 'Toilet, Mushola',
                'tariformawa' => 100000,
                'tarifunit' => 150000,
                'tarifumum' => 200000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 1,
                'nama' => 'Gedung Rektorat',
                'gambar' => 'gedung-rektoran.jpg',
                'deskripsi' => 'Gedung rektorat',
                'kapasitas' => 50,
                'fasilitas' => 'AC, Sound System, Proyektor, Meja Rapat',
                'tariformawa' => 0,
                'tarifunit' => 300000,
                'tarifumum' => 0,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 1,
                'nama' => 'Perpustakaan',
                'gambar' => 'perpustakaan.jpg',
                'deskripsi' => 'Perpustakaan dengan koleksi lengkap',
                'kapasitas' => 200,
                'fasilitas' => 'AC, Rak Buku, Meja Baca, WiFi',
                'tariformawa' => 0,
                'tarifunit' => 0,
                'tarifumum' => 0,
                'status' => 'aktif'
            ],
            // Gedung Tunggal
            [
                'IdKategori' => 2,
                'nama' => 'Auditorium',
                'gambar' => 'auditorium.jpg',
                'deskripsi' => 'Ruang serbaguna untuk acara besar',
                'kapasitas' => 1000,
                'fasilitas' => 'AC, Sound System, Proyektor, Kursi',
                'tariformawa' => 500000,
                'tarifunit' => 750000,
                'tarifumum' => 1000000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 2,
                'nama' => 'Convention Hall',
                'gambar' => 'convention-hall.jpg',
                'deskripsi' => 'Ruang konvensi untuk berbagai acara',
                'kapasitas' => 800,
                'fasilitas' => 'AC, Sound System, Proyektor, Kursi',
                'tariformawa' => 400000,
                'tarifunit' => 600000,
                'tarifumum' => 800000,
                'status' => 'aktif'
            ],
            // Lapangan
            [
                'IdKategori' => 3,
                'nama' => 'Lapangan Futsal',
                'gambar' => 'lap-futsal.jpg',
                'deskripsi' => 'Lapangan futsal outdoor',
                'kapasitas' => 100,
                'fasilitas' => 'Gawang, Lampu',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 3,
                'nama' => 'Lapangan Tenis',
                'gambar' => 'lap-tenis.jpg',
                'deskripsi' => 'Lapangan tenis outdoor',
                'kapasitas' => 50,
                'fasilitas' => 'Net, Lampu',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 3,
                'nama' => 'Lapangan Badminton',
                'gambar' => 'lap-badminton.jpg',
                'deskripsi' => 'Lapangan badminton outdoor',
                'kapasitas' => 20,
                'fasilitas' => 'Net, Lampu',
                'tariformawa' => 50000,
                'tarifunit' => 75000,
                'tarifumum' => 100000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 3,
                'nama' => 'Lapangan Bola Kaki',
                'gambar' => 'lap-bola.jpg',
                'deskripsi' => 'Lapangan sepak bola berumput',
                'kapasitas' => 5000,
                'fasilitas' => 'Gawang, Lampu',
                'tariformawa' => 100000,
                'tarifunit' => 150000,
                'tarifumum' => 200000,
                'status' => 'aktif'
            ],
            [
                'IdKategori' => 3,
                'nama' => 'Lapangan Bumi Perkemahan',
                'gambar' => 'lap-kemah.jpg',
                'deskripsi' => 'Area perkemahan outdoor',
                'kapasitas' => 5000,
                'fasilitas' => 'Toilet, Mushola, Pos Jaga',
                'tariformawa' => 200000,
                'tarifunit' => 300000,
                'tarifumum' => 400000,
                'status' => 'aktif'
            ],
        ];

        foreach ($sarana as $s) {
            Sarana::create($s);
        }
    }
}