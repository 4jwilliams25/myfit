<?php

namespace Tests\Unit;

use App\Models\Exercise;
use App\Models\Diary;
use App\Models\Food;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiaryUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_exercises_for_one_diary()
    {
        User::factory()->create();
        $related_exercises = Exercise::factory()->count(3)->create();
        Exercise::factory()->count(2)->create();
        $diary = Diary::factory()->hasAttached($related_exercises)->create();

        $response = $diary->exercises->toArray();

        $this->assertCount(5, Exercise::all());
        $this->assertEquals(3, count($response));
    }

    public function test_get_all_recipes_for_one_diary()
    {
        User::factory()->create();
        $related_recipes = Recipe::factory()->count(3)->create();
        Recipe::factory()->count(2)->create();
        $diary = Diary::factory()->hasAttached($related_recipes)->create();

        $response = $diary->recipes;

        $this->assertCount(5, Recipe::all());
        $this->assertCount(3, $response);
    }

    public function test_get_all_foods_for_one_diary()
    {
        User::factory()->create();
        $related_foods = Food::factory()->count(4)->create();
        Food::factory()->count(2)->create();
        $diary = Diary::factory()->hasAttached($related_foods)->create();

        $response = $diary->food;

        $this->assertCount(6, Food::all());
        $this->assertCount(4, $response);
    }
}
