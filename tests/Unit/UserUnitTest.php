<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Exercise;
use App\Models\Goal;
use App\Models\Grocery;
use App\Models\Recipe;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_exercises_for_one_user()
    {
        $related_exercises = Exercise::factory()->count(3)->create();
        Exercise::factory()->count(2)->create();
        $user = User::factory()->hasAttached($related_exercises)->create();

        $response = $user->exercises;

        $this->assertCount(5, Exercise::all());
        $this->assertCount(3, $response);
    }

    public function test_get_all_groceries_for_one_user()
    {
        User::factory()->count(2)->create();
        Grocery::factory()->createMany([
            ['user_id' => 1],
            ['user_id' => 1],
            ['user_id' => 2],
        ]);
        $user = User::first();

        $response = $user->groceries->toArray();

        $this->assertCount(3, Grocery::all());
        $this->assertEquals(2, count($response));
        $this->assertEquals(1, $response[0]['user_id']);
        $this->assertEquals(1, $response[1]['user_id']);
    }

    public function test_get_all_recipes_for_one_user()
    {
        $related_recipes = Recipe::factory()->count(4)->create();
        Recipe::factory()->count(4)->create();
        $user = User::factory()->hasAttached($related_recipes)->create();

        $response = $user->recipes->toArray();

        $this->assertCount(8, Recipe::all());
        $this->assertEquals(4, count($response));
    }

    public function test_get_all_workouts_for_one_user()
    {
        $related_workouts = Workout::factory()->count(3)->create();
        Workout::factory()->count(2)->create();
        $user = User::factory()->hasAttached($related_workouts)->create();

        $response = $user->workouts;

        $this->assertCount(5, Workout::all());
        $this->assertCount(3, $response);
    }

    public function test_get_goals_user()
    {
        $user1 = User::factory()->create();
        User::factory()->create();
        $goals = Goal::factory()->create();

        $user = $goals->user;

        $this->assertCount(2, User::all());
        $this->assertCount(1, Goal::all());
        $this->assertCount(8, $user->toArray());
        $this->assertEquals($user1->name, $user->name);
    }
}
