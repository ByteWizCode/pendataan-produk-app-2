<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pesanan>
 */
class PesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pelanggan = Pelanggan::all()->random();
        $produk = Produk::all()->random();
        $jumlah = $this->faker->numberBetween(1, 10);

        $random = $this->faker->randomFloat(1, 0, 1);
        $status = $random < 0.9 ? 'submitted' : ($random < 0.95 ? 'cancel' : 'pending');

        return [
            'pelanggan_id' => $pelanggan->user_id,
            'status' => $status,
            'produk_id' => $produk->id,
            'harga' => $produk->harga_jual,
            'jumlah' => $jumlah,
            'total' => $produk->harga_jual * $jumlah,
            'staff_id' => null,
            'submitted_at' => $this->faker->dateTimeBetween('2023-01-01', 'now'),
        ];
    }
}
