<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'admin',
                'jenis_kelamin' => null,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('Password123!'),
                'role' => 'admin',
            ],
            [
                'nama' => 'staff',
                'jenis_kelamin' => 'P',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('Password123!'),
                'role' => 'staff',
            ],
            [
                'nama' => 'pelanggan',
                'jenis_kelamin' => 'P',
                'email' => 'pelanggan@gmail.com',
                'password' => Hash::make('Password123!'),
                'role' => 'pelanggan',
            ],
        ]);
    }
}
