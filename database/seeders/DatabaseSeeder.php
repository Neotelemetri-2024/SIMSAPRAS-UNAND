<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            KategoriSaranaSeeder::class,
            JadwalSeeder::class,
            PengumumanSeeder::class,

            SaranaSeeder::class,

            PengaduanSeeder::class,

            RuanganSeeder::class,
            GambarSaranaSeeder::class,
            PenjagaSeeder::class,
            AdminAccessSeeder::class,

            GambarRuanganSeeder::class,

            PeminjamanSeeder::class,

            TanggalPeminjamanSeeder::class,
            NotifikasiSeeder::class,
        ]);
    }
}