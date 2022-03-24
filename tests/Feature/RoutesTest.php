<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Exercise;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // Test Welcome
    public function test_welcome()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // Test Recipe (singular)
    public function test_recipe()
    {
        $response = $this->get('/recipes/1');

        $response->assertStatus(200);
    }

    // Test Recipes (all)
    public function test_recipes()
    {
        $response = $this->get('/recipes');

        $response->assertStatus(200);
    }

    // Test Recipe Browser
    public function test_recipe_browser()
    {
        $response = $this->get('/recipes/browse');

        $response->assertStatus(200);
    }

    // Test Groceries
    public function test_groceries()
    {
        $response = $this->get('/groceries');

        $response->assertStatus(200);
    }

    // Test Food Diary
    public function test_food_diary()
    {
        $response = $this->get('/eats');

        $response->assertStatus(200);
    }

    // Test Nutritional Breakdown
    public function test_nutrition()
    {
        $response = $this->get('/eats/nutrition');

        $response->assertStatus(200);
    }

    // Test Exercise (singular)
    public function test_exercise()
    {
        // $exercise = Exercise::factory()->count(1)->make();

        // dd($exercise[0]['id']);

        $response = $this->get('/exercises/1');

        $response->assertStatus(200);
    }

    // Test Exercises (all)
    public function test_exercises()
    {
        $response = $this->get('/exercises');

        $response->assertStatus(200);
    }

    // Test Exercise Diary
    public function test_exercise_diary()
    {
        $response = $this->get('/workouts');

        $response->assertStatus(200);
    }
}
