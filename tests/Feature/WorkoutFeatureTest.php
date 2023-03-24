<?php

use App\Models\Workout;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class WorkoutFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_workout()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/workouts', $this->data());
        $workout = Workout::first();

        $this->assertCount(1, Workout::all());
        $this->assertEquals('Chest Day Best Day', $workout->name);
        $this->assertEquals('Chest olympics ho!', $workout->description);
        $this->assertEquals(1, count($workout->users->toArray()));
        $response->assertRedirect('/workout/edit/' . $workout->id);
    }

    public function test_get_one_workout()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $this->actingAs($user)->withSession(['banned' => false])->post('/workouts', $this->data());
        Workout::factory()->count(3)->create();
        $workout = Workout::first();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/workout/' . $workout->id);

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
        $this->create_authenticated_user();
        $user = Auth::user();
        $this->actingAs($user)->withSession(['banned' => false])->post('/workouts', $this->data());
        Workout::factory()->count(3)->create();
        $workout = Workout::first();

        $this->actingAs($user)->withSession(['banned' => false])->patch('/workouts/' . $workout->id, array_merge($this->data(), [
            'description' => 'This is my chest day bro!'
        ]));

        $this->assertCount(4, Workout::all());
        $this->assertEquals('Chest Day Best Day', Workout::first()->name);
        $this->assertEquals('This is my chest day bro!', Workout::first()->description);
    }

    public function test_delete_one_workout()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        Workout::factory()->count(3)->create();
        $workout = Workout::first();

        $response = $this->actingAs($user)->withSession(['banned' => false])->delete('/workouts/' . $workout->id);

        $this->assertCount(2, Workout::all());
        $response->assertRedirect('/workouts/' . $user->id);
        $this->assertCount(0, $workout->users->toArray());
    }

    private function create_authenticated_user()
    {
        $user = User::factory()->create();
        Auth::login($user);
    }

    private function data()
    {
        return [
            'name' => 'Chest Day Best Day',
            'description' => 'Chest olympics ho!'
        ];
    }
}
