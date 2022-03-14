<?php

namespace Database\Factories;

use App\Models\Paket;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailTransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $transaksi = Transaksi::withCount('detailTransaksi')->get();
        $transaksi = $transaksi->where('detail_transaksi_count', 0)->where('detail_transaksi_count', '<=', 5)->random();
        $paket = Paket::inRandomOrder()->first();

        return [
            'transaksi_id' => $transaksi->id,
            'paket_id' => $paket->id,
            'qty' => $this->faker->numberBetween(1, 10),
            'harga' => $paket->harga,
            'keterangan' => $this->faker->sentence(5),
        ];
    }
}
