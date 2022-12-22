<?php

namespace Tests\Feature;

use App\Models\Exercise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExerciseFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_exercise()
    {
        $this->post('/exercises', $this->data());

        $this->assertCount(1, Exercise::all());
        $this->assertEquals('Flat Bar Bench', Exercise::first()->name);
        $this->assertEquals(10, Exercise::first()->repetitions);
        $this->assertEquals(3, Exercise::first()->sets);
        $this->assertEquals(45, Exercise::first()->weight);
        $this->assertEquals('exceeded once', Exercise::first()->notes);
    }

    public function test_get_all_exercises()
    {
        $this->withoutExceptionHandling();

        Exercise::factory()->count(3)->create();

        $response = $this->get('/exercises');

        $this->assertCount(3, Exercise::all());
        $response->assertJsonCount(3);
    }

    public function test_get_one_exercise()
    {
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();

        $exercise = $this->get('/exercise/' . $exercise2->id)['exercise']->toArray();

        $this->assertCount(2, Exercise::all());
        $this->assertEquals($exercise[0]->name, $exercise2->name);
        $this->assertEquals($exercise[0]->repetitions, $exercise2->repetitions);
    }

    public function test_update_one_exercise()
    {
        $exercise = Exercise::factory()->create();

        $this->patch('/exercises/' . $exercise->id, array_merge($this->data(), [
            'notes' => 'exceeded twice',
            'weight' => 50
        ]))->assertRedirect('/exercises/' . $exercise->id);

        $this->assertCount(1, Exercise::all());
        $this->assertEquals('exceeded twice', Exercise::first()->notes);
        $this->assertEquals(50, Exercise::first()->weight);
    }

    public function test_delete_one_exercise()
    {
        $exercise = Exercise::factory()->create();

        $this->assertCount(1, Exercise::all());

        $response = $this->delete('/exercise/' . $exercise->id);

        $this->assertCount(0, Exercise::all());
        $response->assertRedirect('/exercises');
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
