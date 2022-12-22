<?php

use App\Models\Diary;
use App\Models\Food;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_users_for_one_recipe()
    {
        $related_users = User::factory()->count(3)->create();
        User::factory()->count(2)->create();
        $recipe = Recipe::factory()->hasAttached($related_users)->create();

        $response = $recipe->users->toArray();

        $this->assertCount(5, User::all());
        $this->assertEquals(3, count($response));
    }

    public function test_get_all_ingredients_for_one_recipe()
    {
        $related_ingredients = Food::factory()->count(4)->create();
        Food::factory()->count(2)->create();
        $recipe = Recipe::factory()->hasAttached($related_ingredients)->create();

        $response = $recipe->food;

        $this->assertCount(6, Food::all());
        $this->assertCount(4, $response);
    }

    public function test_get_all_diaries_for_one_recipe()
    {
        User::factory()->create();
        $related_diaries = Diary::factory()->count(2)->create();
        Diary::factory()->count(6)->create();
        $recipe = Recipe::factory()->hasAttached($related_diaries)->create();

        $response = $recipe->diaries;

        $this->assertCount(8, Diary::all());
        $this->assertCount(2, $response);
    }
}
