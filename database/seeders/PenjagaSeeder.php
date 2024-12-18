<?php
// database/seeders/PenjagaSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penjaga;

class PenjagaSeeder extends Seeder
{
    public function run()
    {
        $penjaga = [
            [
                'idSarana' => 1,
                'nama' => 'Budi Santoso',
                'kontak' => '081234567892'
            ],
            [
                'idSarana' => 2,
                'nama' => 'Ahmad Ridwan',
                'kontak' => '081234567893'
            ],
            [
                'idSarana' => 3,
                'nama' => 'Rudi Hermawan',
                'kontak' => '081234567894'
            ]
        ];

        foreach ($penjaga as $p) {
            Penjaga::create($p);
        }
    }
}