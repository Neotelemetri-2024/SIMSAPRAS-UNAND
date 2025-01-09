<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $sarana = \App\Models\Sarana::all();
        $users = \App\Models\User::where('role', 'user')->get();

        foreach ($sarana as $s) {
            foreach ($users as $u) {
                \App\Models\Pengaduan::create([
                    'judul' => $faker->sentence(),
                    'deskripsi' => $faker->paragraph(),
                    'id_sarana' => $s->id,
                    'foto' => $faker->imageUrl(640, 480, 'cats', true, 'Faker'),
                    'user_id' => $u->id,
                ]);
            }
        }
    }
}