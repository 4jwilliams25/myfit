<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_of_measure' => $this->faker->randomElement([
                'gram',
                'lb',
                'ounce'
            ]),
            'food_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
