<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'repetitions' => 4,
            'sets' => 15,
            'weight' => $this->faker->numberBetween(25, 65),
            'notes' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}