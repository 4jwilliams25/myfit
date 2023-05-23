<?php

namespace Tests\Unit;

use App\Models\Diary;
use App\Models\Food;
use App\Models\Recipe;
use App\Models\Serving;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoodUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_serving_types_for_one_food()
    {
        Food::factory()->count(2)->create();
        Serving::factory()->createMany([
            ['food_id' => 1],
            ['food_id' => 1],
            ['food_id' => 2],
        ]);
        $food = Food::first();

        $response = $food->servingTypes->toArray();

        $this->assertCount(3, Serving::all());
        $this->assertEquals(2, count($response));
        $this->assertEquals(1, $response[0]['food_id']);
        $this->assertEquals(1, $response[1]['food_id']);
    }

    public function test_get_all_recipes_for_one_food()
    {
        $related_recipes = Recipe::factory()->count(3)->create();
        Recipe::factory()->count(3)->create();
        $food = Food::factory()->hasAttached($related_recipes)->create();

        $response = $food->recipes;

        $this->assertCount(6, Recipe::all());
        $this->assertCount(3, $response);
    }

    public function test_get_all_diaries_for_one_food()
    {
        User::factory()->create();
        $related_diaries = Diary::factory()->count(4)->create();
        Diary::factory()->count(4)->create();
        $food = Food::factory()->hasAttached($related_diaries, ['meal' => 'Dinner'])->create();

        $response = $food->diaries;

        $this->assertCount(8, Diary::all());
        $this->assertCount(4, $response);
    }
}
