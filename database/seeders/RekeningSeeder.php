<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rekening;

class RekeningSeeder extends Seeder
{
    public function run(): void
    {
        Rekening::create([
            'nama_bank' => 'Bank Mandiri',
            'nomor_rekening' => '1234567890',
            'nama_pemilik' => 'UNAND',
            'is_aktif' => true,
        ]);

        Rekening::create([
            'nama_bank' => 'Bank BNI',
            'nomor_rekening' => '0987654321',
            'nama_pemilik' => 'UNAND',
            'is_aktif' => false,
        ]);
    }
}
