<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OutletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->company(),
            'alamat' => $this->faker->address(),
            'tlp' => $this->faker->phoneNumber(),
        ];
    }
}
