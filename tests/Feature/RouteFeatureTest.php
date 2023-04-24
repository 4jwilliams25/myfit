<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Food;
use App\Models\Goal;
use App\Models\Grocery;
use App\Models\Recipe;
use App\Models\Workout;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RouteFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_route()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    public function test_my_stuff_route()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/mystuff');

        $response->assertStatus(200);
        $response->assertViewIs('my_stuff.index');
    }

    public function test_diary_route()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/diary');

        $response->assertStatus(200);
        $response->assertViewIs('diary.index');
    }

    public function test_diary_nutritional_breakdown_route()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/diary/nutrition');

        $response->assertStatus(200);
        $response->assertViewIs('diary.daily_nutritional_breakdown');
    }

    public function test_exercise_listview_route()
    {
        $this->withoutExceptionHandling();
        Workout::factory()->create();
        Exercise::factory()->count(3)->create();

        $response = $this->get('/exercises/list');

        $response->assertStatus(200);
        $response->assertViewIs('exercises.index');
        $response->assertViewHas('exercises');
        $response->assertViewHas('workouts');
    }

    public function test_exercise_editview_route()
    {
        $exercise = Exercise::factory()->create();
        $response = $this->get('/exercise/' . $exercise->id);

        $response->assertStatus(200);
        $response->assertViewIs('exercises.exercise_edit');
        $response->assertViewHas('exercise');
    }

    public function test_exercise_createview_route()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/exercise/create');

        $response->assertStatus(200);
        $response->assertViewIs('exercises.exercise_create');
    }

    public function test_food_listview_route()
    {
        $this->withoutExceptionHandling();

        Food::factory()->count(4)->create();

        $response = $this->get('/food/list');

        $response->assertStatus(200);
        $response->assertViewIs('food.food_list');
        $response->assertViewHas('food');
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
        $this->create_authenticated_user();
        $user = Auth::user();
        $food = Food::factory()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/food/edit/' . $food->id);

        $response->assertStatus(200);
        $response->assertViewIs('food.food_edit');
        $response->assertViewHas('food');
        $this->assertEquals(Food::first()->name, $response['food'][0]->name);
    }

    public function test_groceries_listview_route()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        Grocery::factory()->count(3)->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/groceries/' . $user->id);

        $response->assertStatus(200);
        $response->assertViewIs('groceries.index');
        $response->assertViewHas('groceries');
        $this->assertEquals(3, count($response['groceries']));
    }

    public function test_users_recipes_listview_route()
    {
        $related_recipes = Recipe::factory()->count(4)->create();
        Recipe::factory()->count(2)->create();
        $user = User::factory()->hasAttached($related_recipes)->create();
        Auth::login($user);
        $authUser = Auth::user();

        $response = $this->actingAs($authUser)->withSession(['banned' => false])->get('/recipes/' . $user->id);

        $response->assertStatus(200);
        $response->assertViewIs('recipes.index');
        $response->assertViewHas('recipes');
        $this->assertCount(6, Recipe::all());
        $this->assertCount(4, $response['recipes']->toArray());
    }

    public function test_recipe_detailview_route()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->get('/recipe/details/' . $recipe->id);

        $response->assertStatus(200);
        $response->assertViewIs('recipes.recipe_details');
        $response->assertViewHas('recipe');
    }

    public function test_recipe_editview_route()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/recipe/edit/' . $recipe->id);

        $response->assertStatus(200);
        $response->assertViewIs('recipes.recipe_edit');
        $response->assertViewHas('recipe');
    }

    public function test_workout_listview_route()
    {
        $related_workouts = Workout::factory()->count(3)->create();
        Workout::factory()->count(3)->create();
        $user = User::factory()->hasAttached($related_workouts)->create();
        Auth::login($user);
        $authUser = Auth::user();

        $response = $this->actingAs($authUser)->withSession(['banned' => false])->get('/workouts/' . $user->id);

        $response->assertStatus(200);
        $response->assertViewIs('workouts.index');
        $response->assertViewHas('workouts');
        $this->assertCount(6, Workout::all());
        $this->assertCount(3, $response['workouts']->toArray());
    }

    public function test_workout_createview_route()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/workout/create');

        $response->assertStatus(200);
        $response->assertViewIs('workouts.workout_create');
    }

    public function test_workout_editview_route()
    {
        $related_exercises = Exercise::factory()->count(4)->create();
        $workout = Workout::factory()->hasAttached($related_exercises)->create();
        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/workout/edit/' . $workout->id);

        $response->assertStatus(200);
        $response->assertViewIs('workouts.workout_edit');
        $response->assertViewHas('workoutExercises');
        $response->assertViewHas('userExercises');
        $response->assertViewHas('allExercises');
        $response->assertViewHas('workout');
        $this->assertCount(4, $response['workoutExercises']->toArray());
    }

    public function test_goals_detailview_route()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        Goal::factory()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/goals/details/' . $user->id);

        $response->assertStatus(200);
        $response->assertViewIs('goals.goals_detail');
        $response->assertViewHas('goals');
        $this->assertCount(8, $response['goals']->toArray());
    }

    public function test_goals_editview_route()
    {
        $this->withoutExceptionHandling();

        $this->create_authenticated_user();
        $user = Auth::user();
        Goal::factory()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/goals/edit/' . $user->id);

        $response->assertStatus(200);
        $response->assertViewIs('goals.goals_edit');
        $response->assertViewHas('goals');
        $this->assertCount(8, $response['goals']->toArray());
    }

    private function create_authenticated_user()
    {
        $user = User::factory()->create();
        Auth::login($user);
    }
}
