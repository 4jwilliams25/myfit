<?php

use App\Models\Workout;
use App\Models\User;
use App\Models\Exercise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkoutUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_users_for_one_workout()
    {
        $related_users = User::factory()->count(2)->create();
        User::factory()->count(5)->create();
        $workout = Workout::factory()->hasAttached($related_users)->create();

        $response = $workout->users;

        $this->assertCount(7, User::all());
        $this->assertCount(2, $response);
    }

    public function test_get_all_exercises_for_one_workout()
    {
        $related_exercises = Exercise::factory()->count(6)->create();
        Exercise::factory()->count(6)->create();
        $workout = Workout::factory()->hasAttached($related_exercises)->create();

        $response = $workout->exercises;

        $this->assertCount(12, Exercise::all());
        $this->assertCount(6, $response);
    }
}
