<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ExerciseFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_exercise()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $this->actingAs($user)->withSession(['banned' => false])->post('/exercises', $this->data());

        $this->assertCount(1, Exercise::all());
        $this->assertEquals('Flat Bar Bench', Exercise::first()->name);
        $this->assertEquals(10, Exercise::first()->repetitions);
        $this->assertEquals(3, Exercise::first()->sets);
        $this->assertEquals(45, Exercise::first()->weight);
        $this->assertEquals('exceeded once', Exercise::first()->notes);
        $this->assertEquals(Exercise::first()->users[0]->id, $user->id);
    }

    public function test_add_one_exercise_to_one_workout()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $workout = Workout::factory()->create();
        $exercise = Exercise::factory()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/exercise/' . $exercise->id . '/' . $workout->id);

        $response->assertStatus(302);
        $this->assertEquals($exercise->id, $workout->exercises[0]->id);
        $response->assertRedirect('/exercises/list/' . $workout->id);
    }

    public function test_remove_exercise_from_workout()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $exercise = Exercise::factory()->create();
        $workout = Workout::factory()->hasAttached($exercise)->create();

        $this->assertDatabaseHas('exercise_workout', [
            'exercise_id' => $exercise->id,
            'workout_id' => $workout->id
        ]);

        $response = $this->actingAs($user)->withSession(['banned' => false])->delete('/exercise/' . $exercise->id . '/' . $workout->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('exercise_workout', [
            'exercise_id' => $exercise->id,
            'workout_id' => $workout->id
        ]);
    }

    public function test_get_all_exercises()
    {
        Exercise::factory()->count(3)->create();

        $response = $this->get('/exercises');

        $this->assertCount(3, Exercise::all());
        $response->assertJsonCount(3);
    }

    public function test_get_one_exercise()
    {
        Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();

        $exercise = $this->get('/exercise/' . $exercise2->id)['exercise'];

        $this->assertCount(2, Exercise::all());
        $this->assertEquals($exercise->name, $exercise2->name);
        $this->assertEquals($exercise->repetitions, $exercise2->repetitions);
    }

    public function test_update_one_exercise()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $exercise = Exercise::factory()->create();

        $this->actingAs($user)->withSession(['banned' => false])->patch('/exercises/' . $exercise->id, array_merge($this->data(), [
            'notes' => 'exceeded twice',
            'weight' => 50
        ]))->assertRedirect('/exercise/' . $exercise->id);

        $this->assertCount(1, Exercise::all());
        $this->assertEquals('exceeded twice', Exercise::first()->notes);
        $this->assertEquals(50, Exercise::first()->weight);
    }

    public function test_delete_one_exercise()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $exercise = Exercise::factory()->create();

        $this->assertCount(1, Exercise::all());

        $response = $this->actingAs($user)->withSession(['banned' => false])->delete('/exercise/' . $exercise->id);

        $this->assertCount(0, Exercise::all());
        $response->assertRedirect('/exercises/list');
    }

    private function create_authenticated_user()
    {
        $user = User::factory()->create();
        Auth::login($user);
    }

    private function data()
    {
        return [
            'name' => 'Flat Bar Bench',
            'repetitions' => 10,
            'sets' => 3,
            'weight' => 45,
            'notes' => 'exceeded once',
        ];
    }
}
