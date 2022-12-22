<?php

namespace Tests\Unit;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Diary;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExerciseUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_users_for_one_exercise()
    {
        $related_users = User::factory()->count(2)->create();
        User::factory()->count(4)->create();
        $exercise = Exercise::factory()->hasAttached($related_users)->create();

        $response = $exercise->users;

        $this->assertCount(6, User::all());
        $this->assertCount(2, $response);
    }

    public function test_get_all_diaries_for_one_exercise()
    {
        User::factory()->count(2)->create();
        $related_diaries = Diary::factory()->count(2)->create();
        Diary::factory()->count(2)->create();
        $exercise = Exercise::factory()->hasAttached($related_diaries)->create();

        $response = $exercise->diaries->toArray();

        $this->assertCount(4, Diary::all());
        $this->assertEquals(2, count($response));
    }

    public function test_get_all_workouts_for_one_exercise()
    {
        $related_workouts = Workout::factory()->count(3)->create();
        Workout::factory()->count(2)->create();
        $exercise = Exercise::factory()->hasAttached($related_workouts)->create();

        $response = $exercise->workouts;

        $this->assertCount(5, Workout::all());
        $this->assertCount(3, $response);
    }
}
