<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // 1. Tabel independen (tidak memiliki foreign key)
            UserSeeder::class,
            KategoriSaranaSeeder::class,
            JadwalSeeder::class,
            PengumumanSeeder::class,

            // 2. Tabel yang bergantung pada kategori
            SaranaSeeder::class,

            // 3. Tabel yang bergantung pada sarana
            RuanganSeeder::class,
            GambarSaranaSeeder::class,
            PenjagaSeeder::class,
            AdminAccessSeeder::class,

            // 4. Tabel yang bergantung pada ruangan
            GambarRuanganSeeder::class,

            // 5. Tabel yang bergantung pada multiple tabel
            PeminjamanSeeder::class,

            // 6. Tabel yang bergantung pada peminjaman
            TanggalPeminjamanSeeder::class,
            NotifikasiSeeder::class,
        ]);
    }
}