<?php

namespace Database\Factories;

use App\Models\JenisProduk;
use FakerRestaurant\Provider\id_ID\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new Restaurant($this->faker));

        $jenis_produk = JenisProduk::all()->random();
        $harga_beli = $this->faker->numberBetween(10, 30) * 1000;
        $harga_jual = round($harga_beli + ($harga_beli * $this->faker->numberBetween(10, 30) / 100), -3);

        switch ($jenis_produk->id) {
            case 1:
                $nama = $this->faker->foodName();
                break;
            case 2:
                $nama = $this->faker->beverageName();
                break;
            default:
                $nama = $this->faker->foodName();
                break;
        }

        return [
            'nama' => $nama,
            'deskripsi' => $this->faker->sentence(),
            'jenis_produk_id' => $jenis_produk->id,
            'stok' => $this->faker->numberBetween(5, 40),
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'gambar' => $this->faker->imageUrl(),
        ];
    }
}
