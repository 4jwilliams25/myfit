<?php

use App\Models\Workout;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkoutFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_workout()
    {
        $response = $this->post('/workouts', $this->data());
        $workout = Workout::first();

        $this->assertCount(1, Workout::all());
        $this->assertEquals('Chest Day Best Day', $workout->name);
        $this->assertEquals('Chest olympics ho!', $workout->description);
        $response->assertRedirect('/workouts/' . $workout->id);
    }

    public function test_get_one_workout()
    {
        $this->post('/workouts', $this->data());
        Workout::factory()->count(3)->create();
        $workout = Workout::first();

        $response = $this->get('/workout/' . $workout->id);

        $this->assertCount(4, Workout::all());
        $response->assertJsonCount(1);
        $this->assertEquals('Chest Day Best Day', $response[0]['name']);
        $this->assertEquals('Chest olympics ho!', $response[0]['description']);
    }

    public function test_get_all_workouts()
    {
        Workout::factory()->count(6)->create();
        $first_workout = Workout::first();

        $response = $this->get('/workouts');

        $this->assertCount(6, Workout::all());
        $response->assertJsonCount(6);
        $this->assertEquals($first_workout->name, $response[0]['name']);
        $this->assertEquals($first_workout->description, $response[0]['description']);
    }

    public function test_update_one_workout()
    {
        $this->post('/workouts', $this->data());
        Workout::factory()->count(3)->create();
        $workout = Workout::first();

        $response = $this->patch('/workouts/' . $workout->id, array_merge($this->data(), [
            'description' => 'This is my chest day bro!'
        ]));

        $this->assertCount(4, Workout::all());
        $this->assertEquals('Chest Day Best Day', Workout::first()->name);
        $this->assertEquals('This is my chest day bro!', Workout::first()->description);
    }

    public function test_delete_one_workout()
    {
        Workout::factory()->count(3)->create();
        $workout = Workout::first();

        $response = $this->delete('/workouts/' . $workout->id);

        $this->assertCount(2, Workout::all());
        $response->assertRedirect('/workouts');
    }

    private function data()
    {
        return [
            'name' => 'Chest Day Best Day',
            'description' => 'Chest olympics ho!'
        ];
    }
}
