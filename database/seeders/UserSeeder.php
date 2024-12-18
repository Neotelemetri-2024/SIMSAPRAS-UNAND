<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@unand.ac.id',
            'password' => Hash::make('password123'),
            'kontak' => '081234567890',
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@unand.ac.id',
            'password' => Hash::make('password123'),
            'kontak' => '081234567891',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Pimpinan
        User::create([
            'name' => 'Pimpinan',
            'email' => 'pimpinan@unand.ac.id',
            'password' => Hash::make('password123'),
            'kontak' => '081234567892',
            'role' => 'pimpinan',
            'email_verified_at' => now(),
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Demo',
            'email' => 'user@unand.ac.id',
            'password' => Hash::make('password123'),
            'kontak' => '081234567893',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}