<?php

namespace Database\Factories;

use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'outlet_id' => $this->faker->randomElement(Outlet::pluck('id')->toArray()),
            'jenis' => $this->faker->randomElement(['kiloan', 'selimut', 'bed_cover', 'kaos', 'lain']),
            'nama_paket' => $this->faker->word($nb = 3, $asText = true),
            'harga' => round($this->faker->numberBetween(10000, 100000), -3),
        ];
    }
}
