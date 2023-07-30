<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('jenis_produk')->insert([
            [
                'id' => 1,
                'jenis' => 'Makanan',
                'deskripsi' => 'Makanan yang dijual di toko kami',
            ],
            [
                'id' => 2,
                'jenis' => 'Minuman',
                'deskripsi' => 'Minuman yang dijual di toko kami',
            ],
            [
                'id' => 3,
                'jenis' => 'Snack',
                'deskripsi' => 'Snack yang dijual di toko kami',
            ],
        ]);

        Pelanggan::factory()->count(50)->create();
        Produk::factory()->count(50)->create();
        Pesanan::factory()->count(100)->create();

        $this->call([
            UserSeeder::class
        ]);
    }
}
