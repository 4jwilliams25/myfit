<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NutrientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'serving_id' => 1,
            'title' => $this->faker->name(),
            'amount' => $this->faker->numberBetween(15, 75),
            'unit' => 'grams',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
