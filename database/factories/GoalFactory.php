<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'total_calories' => $this->faker->numberBetween(1000, 3000),
            'protein' => $this->faker->numberBetween(100, 250),
            'carbs' => $this->faker->numberBetween(150, 300),
            'fat' => $this->faker->numberBetween(25, 75),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
