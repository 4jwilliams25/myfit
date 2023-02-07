<?php

namespace Tests\Feature;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

use function GuzzleHttp\Promise\all;

class GoalFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_goals()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $this->actingAs($user)->withSession(['banned' => false])->post('/goals', [
            'total_calories' => 2500,
            'protein' => 200,
            'carbs' => 150,
            'fat' => 30,
            'user_id' => $user->id
        ]);

        $this->assertCount(1, Goal::all());
        $this->assertEquals(1, Goal::first()->id);
        $this->assertEquals(2500, Goal::first()->total_calories);
        $this->assertEquals(200, Goal::first()->protein);
        $this->assertEquals(150, Goal::first()->carbs);
        $this->assertEquals(30, Goal::first()->fat);
    }

    public function test_update_goals()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        Goal::factory()->create();

        $this->actingAs($user)->withSession(['banned' => false])->patch('/goals/' . $user->id, [
            'total_calories' => 3000,
            'carbs' => 200,
        ]);
        $goals = Goal::first();

        $this->assertCount(1, Goal::all());
        $this->assertEquals(3000, $goals->total_calories);
        $this->assertEquals($user->goals->protein, $goals->protein);
        $this->assertEquals(200, $goals->carbs);
        $this->assertEquals($user->goals->fat, $goals->fat);
    }

    public function test_delete_goals()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        User::factory()->count(2)->create();
        Goal::factory()->createMany([
            ['user_id' => 1],
            ['user_id' => 2],
            ['user_id' => 3],
        ]);

        $response = $this->actingAs($user)->withSession(['banned' => false])->delete('/goals/' . User::first()->id);

        $this->assertCount(2, Goal::all());
        $response->assertRedirect('/mystuff');
    }

    private function create_authenticated_user()
    {
        $user = User::factory()->create();
        Auth::login($user);
    }
}
