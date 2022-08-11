<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'servings' => $this->faker->randomFloat(2, 1, 5),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
