<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'cook_time' => $this->faker->word(),
            'prep_time' => $this->faker->word(),
            'servings' => $this->faker->randomFloat(2, 1, 5),
            'difficulty' => $this->faker->randomElement([
                'easy',
                'moderate',
                'hard'
            ]),
            'directions' => $this->faker->sentence(),
        ];
    }
}
