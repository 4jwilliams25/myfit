<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExerciseFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_exercise()
    {
        $user = User::factory()->create();

        $this->post('/exercises/' . $user->id, $this->data($user));

        $this->assertCount(1, User::all());
        $this->assertCount(1, Exercise::all());
        $this->assertEquals($user->id, Exercise::first()->user_id);
        $this->assertEquals('Flat Bar Bench', Exercise::first()->name);
        $this->assertEquals(10, Exercise::first()->repetitions);
        $this->assertEquals(3, Exercise::first()->sets);
        $this->assertEquals(45, Exercise::first()->weight);
        $this->assertEquals('exceeded once', Exercise::first()->notes);
    }

    public function test_get_all_exercises()
    {
        $this->withoutExceptionHandling();

        User::factory()->create();
        Exercise::factory()->count(3)->create();

        $response = $this->get('/exercises');

        $this->assertCount(3, Exercise::all());
        $response->assertJsonCount(3);
    }

    public function test_get_one_exercise()
    {
        User::factory()->create();

        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();

        $exercise = $this->get('/exercise/' . $exercise2->id)[0];

        $this->assertCount(2, Exercise::all());
        $this->assertEquals($exercise['name'], $exercise2->name);
        $this->assertEquals($exercise['repetitions'], $exercise2->repetitions);
        $this->assertEquals($exercise['user_id'], $exercise2->user_id);
    }

    public function test_get_all_exercises_for_one_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Exercise::factory()->createMany([
            ['user_id' => 1],
            ['user_id' => 1],
            ['user_id' => 2],
        ]);

        $response = $this->get('exercises/' . $user1->id);

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $this->assertCount(3, Exercise::all());
        $this->assertEquals(1, $response[0]['user_id']);
        $this->assertEquals(1, $response[1]['user_id']);
    }

    public function test_update_one_exercise()
    {
        $user = User::factory()->create();
        $exercise = Exercise::factory()->create();

        $this->patch('/exercises/' . $exercise->id, array_merge($this->data($user), [
            'notes' => 'exceeded twice',
            'weight' => 50
        ]))->assertRedirect('/exercises/' . $exercise->id);

        $this->assertCount(1, Exercise::all());
        $this->assertEquals('exceeded twice', Exercise::first()->notes);
        $this->assertEquals(50, Exercise::first()->weight);
    }

    public function test_delete_one_exercise()
    {
        User::factory()->create();
        $exercise = Exercise::factory()->create();

        $this->assertCount(1, Exercise::all());

        $response = $this->delete('/exercise/' . $exercise->id);

        $this->assertCount(0, Exercise::all());
        $response->assertRedirect('/exercises');
    }

    private function data(User $user)
    {
        return [
            'name' => 'Flat Bar Bench',
            'repetitions' => 10,
            'sets' => 3,
            'weight' => 45,
            'notes' => 'exceeded once',
            'user_id' => $user->id
        ];
    }
}
