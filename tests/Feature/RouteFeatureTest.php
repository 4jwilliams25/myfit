<?php

namespace Tests\Feature;

use App\Http\Controllers\DiaryController;
use App\Models\Exercise;
use App\Models\Food;
use App\Models\Grocery;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_route()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    public function test_my_stuff_route()
    {
        $response = $this->get('/mystuff');

        $response->assertStatus(200);
        $response->assertViewIs('my_stuff.index');
    }

    public function test_diary_route()
    {
        $response = $this->get('/diary');

        $response->assertStatus(200);
        $response->assertViewIs('diary.index');
    }

    public function test_diary_nutritional_breakdown_route()
    {
        $response = $this->get('/diary/nutrition');

        $response->assertStatus(200);
        $response->assertViewIs('diary.daily_nutritional_breakdown');
    }

    public function test_exercise_listview_route()
    {
        $response = $this->get('/exercises/list');

        $response->assertStatus(200);
        $response->assertViewIs('exercises.index');
        $response->assertViewHas('exercises');
    }

    public function test_exercise_editview_route()
    {
        $exercise = Exercise::factory()->create();
        $response = $this->get('/exercise/' . $exercise->id);

        $response->assertStatus(200);
        $response->assertViewIs('exercises.exercise_details');
        $response->assertViewHas('exercise');
    }

    public function test_food_detailview_route()
    {
        $food = Food::factory()->create();

        $response = $this->get('/food/details/' . $food->id);

        $response->assertStatus(200);
        $response->assertViewIs('food.index');
        $response->assertViewHas('food');
    }

    public function test_food_editview_route()
    {
        $food = Food::factory()->create();

        $response = $this->get('/food/edit/' . $food->id);

        $response->assertStatus(200);
        $response->assertViewIs('food.food_edit');
        $response->assertViewHas('food');
        $this->assertEquals(Food::first()->name, $response['food'][0]->name);
    }

    public function test_groceries_listview_route()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Grocery::factory()->count(3)->create();

        $response = $this->get('/groceries/' . $user->id);

        $response->assertStatus(200);
        $response->assertViewIs('groceries.index');
        $response->assertViewHas('groceries');
        $this->assertEquals(3, count($response['groceries']));
    }

    // public function test_users_recipes_listview_route()
    // {
    //     $related_recipes = Recipe::factory()->count(4)->create();
    //     Recipe::factory()->count(2)->create();
    //     $user = User::factory()->hasAttached($related_recipes)->create();

    //     $response = $this->get('/recipes/' . $user->id);

    // }
}
