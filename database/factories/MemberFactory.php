<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'tlp' => $this->faker->phoneNumber(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
        ];
    }
}
